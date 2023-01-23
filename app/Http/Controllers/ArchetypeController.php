<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArchetypeRequest;
use App\Http\Requests\UpdateArchetypeRequest;
use App\Models\Archetype;

class ArchetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('archetype.index', ['archetypes'=>Archetype::get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Archetype  $archetype
     * @return \Illuminate\Http\Response
     */
    public function show(Archetype $archetype)
    {
        //
        return view('archetype.show', $archetype);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArchetypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArchetypeRequest $request)
    {
        //
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Archetype  $archetype
     * @return \Illuminate\Http\Response
     */
    public function edit(Archetype $archetype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArchetypeRequest  $request
     * @param  \App\Models\Archetype  $archetype
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArchetypeRequest $request, Archetype $archetype)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archetype  $archetype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archetype $archetype)
    {
        //
    }
}
