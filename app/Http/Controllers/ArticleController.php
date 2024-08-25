<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        throw new \Exception('Not implemented');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Law $law)
    {
        $valid = $request->validate([
            'article_name' => 'required|string|max:255',
        ]);

        $article = new Article($valid);
        $law->articles()->save($article);

        return redirect(route('laws.show', ['law' => $law->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Law $law, Article $article)
    {
        $article->load('items');
        return view('articles.show', compact('law', 'article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Law $law, Article $article)
    {
        //
        throw new \Exception('Not implemented');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Law $law, Article $article)
    {
        $valid = $request->validate([
            'article_name' => 'required|string|max:255',
        ]);
        $article->update($valid);
        return redirect(route('laws.show', ['law' => $article->law_id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Law $law, Article $article)
    {
        $article->delete();
        return redirect(route('laws.show', ['law' => $article->law_id]));
    }


    public function validate_items(Request $request, Law $law, Article $article)
    {

        $valid = $request->validate([
            'items' => 'nullable|array',
            'items.*.*' => 'required|in:on',
        ]);

        // disable all items.
        $article->items()->update(
            ['item_is_complete' => false]
        );

        foreach ($valid['items'] ?? [] as $item => $value) {
            // update only found items
            ArticleItem::findOrFail($item)->update(
                ['item_is_complete' => $value === 'on']
            );
        }


        return redirect(route('articles.show', ['law' => $law,'article' => $article->id]));
    }
}
