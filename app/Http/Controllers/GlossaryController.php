<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Glossary;
use League\CommonMark\CommonMarkConverter;
use App\Tools\AnchorTagParser;

class GlossaryController extends Controller
{
    public function show($source, $card)
    {
        $card = Card::where('source_slug', $source)->where('slug',$card)->first();
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

    public function lookup($card)
    {
        $card = Card::where('slug',$card)->first();
        if(empty($card)){
            abort(404);
        }
        $converter = new CommonMarkConverter();
        $atp = new AnchorTagParser();
        return $atp($converter->convert($card->content));
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
