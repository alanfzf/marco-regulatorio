<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use App\Models\MaturityLevel;
use App\Repositories\Law\LawRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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

        $law = $this->lawRepository->create($values);
        $law->managers()->attach($request->user()->id);

        return redirect(route('laws.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Law $law)
    {
        Gate::authorize('view', $law);
        $law->load('articles.items.maturity')->loadCount([
            'articles',
            'articles as compliance_articles' => function ($query) {
                // buscar items que no tengan ni item_is_informative ni maturity menor a 1
                $query->whereDoesntHave('items', function ($query) {
                    $query->where('item_is_informative', false)
                    ->whereHas('maturity', function ($mquery) {
                        $mquery->where('maturity_level', '<', 1);
                    });
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
        Gate::authorize('update', $law);
        return view('laws.edit', compact('law'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Law $law)
    {

        Gate::authorize('update', $law);
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
        Gate::authorize('delete', $law);
        $this->lawRepository->delete($law->id);
        return redirect(route('laws.index'));
    }

    public function report(Law $law)
    {
        Gate::authorize('report', $law);
        $law->loadCount([
                // count the articles and their stats
                'articles',
                'articles as articles_in_compliance' => function ($query) {
                    $query->whereDoesntHave('items', function ($query) {
                        $query->where('item_is_informative', false)
                            ->whereHas('maturity', function ($mquery) {
                                $mquery->where('maturity_level', '<', 1);
                            });
                    });
                },
            'items',
            'items as informative_items_count' => function ($query) {
                $query->where('item_is_informative', true);
            },


            ])
            ->load(['articles' => function ($query) {
                // load the article items and their stats
                $query->withCount([
                    'items as all_items_count',
                    'items as compliance_items_count' => function ($query) {
                        // Count items where either item_is_informative  or they maturity level is greater than or equal to 1
                        $query->where(function ($query) {
                            $query->where('item_is_informative', true)
                                ->orWhereHas('maturity', function ($mquery) {
                                    $mquery->where('maturity_level', '>=', 1);
                                });
                        });
                    },
                ]);
                // second query
                $query->whereHas('items', function ($query) {
                    $query->where('item_is_informative', false)
                        ->whereHas('maturity', function ($mquery) {
                            $mquery->where('maturity_level', '<', 1);
                        });
                });
            }, 'articles.items.maturity']);


        // CALCULATE THE AVERAGE MATURITY LEVEL
        $avgMaturity = Law::find($law->id)
            ->articles()
            ->join('article_items', 'articles.id', '=', 'article_items.article_id')
            ->join('maturity_levels', 'article_items.maturity_id', '=', 'maturity_levels.id')
            ->where('article_items.item_is_informative', false)
            ->avg('maturity_levels.maturity_level');

        // CALCULATE HOW MANY ITEMS ARE IN EACH MATURITY LEVEL
        $maturityLevels = MaturityLevel::select('maturity_levels.maturity_name', DB::raw('COUNT(article_items.id) as article_item_count'))
            ->leftJoin('article_items', 'maturity_levels.id', '=', 'article_items.maturity_id')
            ->leftJoin('articles', 'article_items.article_id', '=', 'articles.id')
            ->leftJoin('laws', 'articles.law_id', '=', 'laws.id')
            ->where('article_items.item_is_informative', false)
            ->where(function ($query) use ($law) {
                $query->where('laws.id', $law->id)
                ->where('article_items.item_is_informative', false);
            })
            ->groupBy('maturity_levels.maturity_name')
            ->orderBy('maturity_levels.maturity_level')
            ->get()->toArray();

        $allMaturityLevels = MaturityLevel::orderBy('maturity_level')
            ->get(['maturity_name'])
            ->map(function ($item) {
                return ['maturity_name' => $item->maturity_name, 'article_item_count' => 0];
            })
            ->toArray();

        $maturityLevels = array_replace($allMaturityLevels, $maturityLevels);
        return view('laws.report', compact('law', 'avgMaturity', 'maturityLevels'));
    }

    public function upload(Request $request, Law $law)
    {
        Gate::authorize('massUpload', $law);
        $request->validate([
            'articles' => 'required|file|mimes:csv',
        ]);

        $file = $request->file('articles');
        $contents = file($file->getRealPath());
        $articles = [];
        array_shift($contents);



        foreach($contents as $index => $line) {
            $data = str_getcsv($line);

            if(count($data) !== 6) {
                throw new \Exception('Invalid CSV format, line: '. $index);
            }

            [$article, $title, $description, $is_informative, $comment, $level] = $data;

            if(array_key_exists($article, $articles)) {
                // push a new item to the article
                $articles[$article]['items'][] = [
                    'name' => $title,
                    'description' => $description,
                    'is_informative' => $is_informative === 'TRUE',
                    'comment' => $comment,
                    'level' => $level,
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
                    $maturity = MaturityLevel::where('maturity_level', $item['level'])
                        ->firstOrFail();
                    $it = new ArticleItem();
                    $it->item_title = $item['name'];
                    $it->item_description = $item['description'];
                    $it->item_is_informative = $item['is_informative'];
                    $it->item_comment = $item['comment'];
                    $it->maturity()->associate($maturity);
                    $articleItems[] = $it;
                }

                $art->items()->saveMany($articleItems);
            }

        });


        return redirect(route('laws.show', ['law' => $law]));
    }
}
