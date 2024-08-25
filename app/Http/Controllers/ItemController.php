<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleItem;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $valid = $request->validate([
            'article' => 'required|exists:articles,id',
        ]);

        return view('items.create', ['article_id' => $valid['article']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['item_is_informative' => $request->has('item_is_informative')]);
        $valid = $request->validate([
            'item_title' => 'required|string|max:255',
            'item_description' => 'nullable|string|max:255',
            'item_is_informative' => 'required|boolean',
            'article_id' => 'required|exists:articles,id',
        ]);

        $article = Article::find($valid['article_id']);

        $item = new ArticleItem([
            'item_title' => $valid['item_title'],
            'item_description' => $valid['item_description'],
            'item_is_informative' => $valid['item_is_informative'],
        ]);

        $article->items()->save($item);

        return redirect(route('articles.show', ['article' => $valid['article_id']]));
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleItem $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArticleItem $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleItem $item)
    {
        $request->merge(['item_is_informative' => $request->has('item_is_informative')]);
        $valid = $request->validate([
            'item_title' => 'required|string|max:255',
            'item_description' => 'nullable|string|max:255',
            'item_is_informative' => 'required|boolean',
        ]);
        $item->update($valid);
        return redirect(route('articles.show', ['article' => $item->article_id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleItem $item)
    {
        $item->delete();
        return redirect(route('articles.show', ['article' => $item->article_id]));
    }
}
