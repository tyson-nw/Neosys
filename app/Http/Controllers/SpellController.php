<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpellRequest;
use App\Http\Requests\UpdateSpellRequest;
use App\Models\Spell;
use App\Tools\AbsoluteUrlResolver;
use Elazar\LeagueCommonMarkObsidian\LeagueCommonMarkObsidianExtension;

class SpellController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $resolver = new AbsoluteUrlResolver(url('/'));
        $extension = new LeagueCommonMarkObsidianExtension(
          attachmentLinkResolver: $resolver,
          internalLinkResolver: $resolver,
        );

        $environment = new \League\CommonMark\Environment\Environment;
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension);
        $environment->addExtension($extension);

        $converter = new \League\CommonMark\MarkdownConverter($environment);

        if(request()->tier){
            if(empty($spells)){
                $spells = Spell::where('tier',request()->tier);;
            }else{
                $spells->where('tier',request()->tier);
            }
        }
        if(request()->classes){
            if(empty($spells)){
                $spells = Spell::where('classes', 'LIKE', "%" .request()->classes ."%");
            }else{
                $spells->where('classes', 'LIKE', "%" .request()->classes ."%");
            }
        }
        if(request()->casting_time){
            if(empty($spells)){
                $spells = Spell::where('casting_time', 'LIKE', "%" .request()->casting_time ."%");
            }else{
                $spells->where('casting_time', 'LIKE', "%" .request()->casting_time ."%");
            }
        }
        if(request()->target){
            if(empty($spells)){
                $spells = Spell::where('target', 'LIKE', "%" .request()->target ."%");
            }else{
                $spells->where('target', 'LIKE', "%" .request()->target ."%");
            }
        }

        if(request()->defense){
            if(empty($spells)){
                $spells = Spell::where('defense', 'LIKE', "%" .request()->defense ."%");
            }else{
                $spells->where('defense', 'LIKE', "%" .request()->defense ."%");
            }
        }

        if(request()->duration){
            if(empty($spells)){
                $spells = Spell::where('duration', 'LIKE', "%" .request()->duration ."%");
            }else{
                $spells->where('duration', 'LIKE', "%" .request()->duration ."%");
            }
        }

        if(request()->concentration){
            if(empty($spells)){
                $spells = Spell::where('concentration', TRUE);
            }else{
                $spells->where('concentration', TRUE);
            }
        }

        if(request()->higher_cast){
            if(empty($spells)){
                $spells = Spell::whereNotNull ('higher_cast');
            }else{
                $spells->whereNotNull ('higher_cast');
            }
        }

        if(isset($spells)){
            return view('spell.index', ['spells'=>$spells->get(),'converter'=>$converter]);
        }
        return view('spell.index', ['spells'=>Spell::get(),'converter'=>$converter]);
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
        $valid = $request->validated();
        Spell::create($valid);
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
        $resolver = new AbsoluteUrlResolver(url('/'));
        $extension = new LeagueCommonMarkObsidianExtension(
          attachmentLinkResolver: $resolver,
          internalLinkResolver: $resolver,
        );

        $environment = new \League\CommonMark\Environment\Environment;
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension);
        $environment->addExtension($extension);

        $converter = new \League\CommonMark\MarkdownConverter($environment);
        $spell->details = $converter->convert($spell->details);
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

/*
        $spell->classes = implode(", ", array_map(function($value){
            $m = [];
            preg_match('/\[\[\#(.*)\]\]/', $value,$m);
            return array_pop($m);
        }, explode(",",$spell->classes)));

        $spell->casting_time = implode(", ", array_map(function($value){
            $m = [];
            preg_match('/\[\[\#(.*)\]\]/', $value,$m);
            return array_pop($m);
        }, explode(",",$spell->casting_time)));
*/
        return view('spell.edit',$spell);
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
        $spell->fill($request->all())->save();
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
        session()->flash('spell_deleted', ['title'=>$spell['title'], 'slug'=>$spell['slug']]);
        $spell->delete();
        return redirect('/spells');
    }
}
