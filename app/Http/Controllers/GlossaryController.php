<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Glossary;

class GlossaryController extends Controller
{
    public function show($source, $term)
    {
        $card = Glossary::where('source_slug', $source)->where('slug',$card)->first();
        if(empty($card)){
            $card = Card::where('slug',$card)->first();
        }
        if(empty($card)){
            abort(404);
        }
        $converter = new CommonMarkConverter();
        $atp = new AnchorTagParser($card->source_slug);
        return $atp($converter->convert($card->content));
    }

    public function lookup($term)
    {
        $cards = Glossary::where('slug',$term)->orderBy('source_slug')->get();
        if(empty($cards)){
            abort(404);
        }

        $out = "<h1>".$cards->first()->title ."</h1>";

        foreach ($cards as $card){
            $out .= view('glossary.view', $card);
        }

        return $out;
    }

    public function index(){
        $cards = Glossary::orderBy('title')->get();
        return view('glossary.index', ['cards'=>$cards]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCardRequest  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCardRequest $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }
}
