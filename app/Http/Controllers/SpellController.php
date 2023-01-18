<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpellRequest;
use App\Http\Requests\UpdateSpellRequest;
use App\Models\Spell;

class SpellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('spell.index', ['spells'=>Spell::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('spell.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSpellRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpellRequest $request)
    {
        
        Page::create($request);
        return redirect('/spells')->with('spell_created', ['title'=>$valid['title'], 'slug'=>$valid['slug']]);
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Spell  $spell
     * @return \Illuminate\Http\Response
     */
    public function show(Spell $spell)
    {
        return view('spell.view',$spell);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Spell  $spell
     * @return \Illuminate\Http\Response
     */
    public function edit(Spell $spell)
    {
        return view('spell.edit',$page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSpellRequest  $request
     * @param  \App\Models\Spell  $spell
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpellRequest $request, Spell $spell)
    {
        $spell->fill($request)->save();
        session()->flash('spell_updated', 'Spell Updated');
        return redirect("/spell/{$spell->slug}"); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Spell  $spell
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spell $spell)
    {
        session()->flash('spell_deleted', ['title'=>$page['title'], 'slug'=>$page['slug']]);
        $page->delete();
        return redirect('/spells');
    }
}
