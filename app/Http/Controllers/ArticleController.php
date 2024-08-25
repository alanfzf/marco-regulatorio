<?php

namespace App\Http\Controllers;

use App\Models\Article;
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
    public function store(Request $request)
    {
        $valid = $request->validate([
            'article_name' => 'required|string|max:255',
            'law_id' => 'required|exists:laws,id'
        ]);

        $law = Law::find($valid['law_id']);
        $article = new Article([
            'article_name' => $valid['article_name'],
        ]);
        $law->articles()->save($article);

        return redirect(route('laws.show', ['law' => $law->id]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load('items');
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
        throw new \Exception('Not implemented');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $valid = $request->validate([
            'article_name' => 'required|string|max:255',
        ]);
        //
        $article->update($valid);
        return redirect(route('laws.show', ['law' => $article->law_id]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect(route('laws.show', ['law' => $article->law_id]));
    }
}
