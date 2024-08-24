<?php

namespace App\Http\Controllers;

use App\Models\Law;
use App\Repositories\Law\LawRepository;
use Illuminate\Http\Request;

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

        $values['law_image'] = $request->file('law_image')->store();

        $this->lawRepository->create($values);

        return redirect(route('laws.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Law $law)
    {
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
        //
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

    public function uploadArticles(Law $law)
    {
    }
}
