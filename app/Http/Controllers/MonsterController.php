<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonsterRequest;
use App\Http\Requests\UpdateMonsterRequest;
use App\Models\Monster;

class MonsterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->size){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%".request()->size."%");;
            }else{
                $monsters->where('content','LIKE',"%".request()->size."%");
            }
        }
        if(request()->type){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%".request()->type."%");;
            }else{
                $monsters->where('content','LIKE',"%".request()->type."%");
            }
        }

        if(request()->challenge){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%".request()->challenge."%");;
            }else{
                $monsters->where('content','LIKE',"%".request()->challenge."%");
            }
        }

        if(request()->bonus_action){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%*Bonus Action*%");;
            }else{
                $monsters->where('content','LIKE',"%*Bonus Action*%");
            }
        }

        if(request()->responses){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%".request()->responses."%");;
            }else{
                $monsters->where('content','LIKE',"%".request()->responses."%");
            }
        }

        if(request()->lair_act){
            if(empty($monsters)){
                $monsters = Monster::where('content','LIKE',"%**Lair Act%");;
            }else{
                $monsters->where('content','LIKE',"%**Lair Act%");
            }
        }



        if(isset($monsters)){
            return view('monster.index', ['monsters'=>$monsters->get()]);
        }
        return view('monster.index', ['monsters'=>Monster::get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function show(Monster $monster)
    {

        return view('monster.view',$monster);
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
     * @param  \App\Http\Requests\StoreMonsterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMonsterRequest $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function edit(Monster $monster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMonsterRequest  $request
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMonsterRequest $request, Monster $monster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Monster $monster)
    {
        //
    }
}
