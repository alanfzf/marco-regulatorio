<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use App\Repositories\Law\LawRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LawController extends Controller
{
    public function __construct(protected LawRepository $lawRepository)
    {

    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('laws.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laws.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $values = $request->validate([
            'law_name' => 'required|string|max:255',
            'law_description' => 'nullable|string',
            'law_publish_date' => 'required|date',
            'law_url_reference' => 'nullable|url',
            'law_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if($request->hasFile('law_image')) {
            $values['law_image'] = $request->file('law_image')->store();
        }

        $this->lawRepository->create($values);
        return redirect(route('laws.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Law $law)
    {

        /*
         * tested_articles: cuenta todos los articulos que tienen que ser evaluados
         * completed_articles: cuenta todos los articulos que tienen sus items como completados
         * es decir que no sean informativos y que se completen, y si es ifnormativo el estado
         * de si esta completado o no es irrelevante
         */

        $law->load('articles.items')->loadCount([
            'articles',
            'articles as compliant_articles' => function ($query) {
                $query->whereDoesntHave('items', function ($query) {
                    $query->where('item_is_informative', false)
                          ->where('item_is_complete', false);
                });
            },
        ]);

        return view('laws.show', compact('law'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Law $law)
    {
        return view('laws.edit', compact('law'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Law $law)
    {
        $values = $request->validate([
            'law_name' => 'required|string|max:255',
            'law_description' => 'nullable|string',
            'law_publish_date' => 'required|date',
            'law_url_reference' => 'nullable|url',
            'law_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if($request->hasFile('law_image')) {
            $values['law_image'] = $request->file('law_image')->store();
        }

        $this->lawRepository->update($law->id, $values);
        return redirect(route('laws.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Law $law)
    {
        $this->lawRepository->delete($law->id);
        return redirect(route('laws.index'));
    }

    public function upload(Request $request, Law $law)
    {

        $request->validate([
            'articles' => 'required|file|mimes:csv',
        ]);

        $file = $request->file('articles');
        $contents = file($file->getRealPath());
        $articles = [];
        array_shift($contents);



        foreach($contents as $line) {
            $data = str_getcsv($line);

            if(count($data) !== 4) {
                throw new \Exception('Invalid CSV format');
            }

            [$article, $title, $description, $is_informative] = $data;


            if(array_key_exists($article, $articles)) {
                // push a new item to the article
                $articles[$article]['items'][] = [
                    'name' => $title,
                    'description' => $description,
                    'is_informative' => $is_informative === 'TRUE',
                ];
            } else {
                // create the base article
                $articles[$article] = [
                    'name' => $title,
                    'description' => $description,
                    'items' => [],
                ];
            }
        }


        DB::transaction(function () use ($articles, $law) {

            $law->articles()->delete();
            foreach($articles as $article) {

                // CREATE THE ARTICLE
                $art = new Article();
                $art->article_name = $article['name'];
                $art->article_description = $article['description'];
                $art->law()->associate($law);
                $art->save();

                $articleItems = [];
                foreach($article['items'] as $item) {
                    $it = new ArticleItem();
                    $it->item_title = $item['name'];
                    $it->item_description = $item['description'];
                    $it->item_is_informative = $item['is_informative'];
                    $articleItems[] = $it;
                }

                $art->items()->saveMany($articleItems);
            }

        });


        return redirect(route('laws.show', ['law' => $law]));
    }
}
