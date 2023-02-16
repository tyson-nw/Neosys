<?php

namespace App\Http\Controllers;

use App\Models\Spell;
use App\Tools\AbsoluteUrlResolver;
use App\Tools\AnchorTagParser;

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
        
        if(request()->title){
            if(empty($spells)){
                $spells = Spell::where('title','LIKE',"%" .request()->title."%");
            }else{
                $spells->where('title','LIKE',"%" .request()->title."%");
            }
        }

        if(request()->tier){
            if(empty($spells)){
                $spells = Spell::where('tier','LIKE',"%" .request()->tier."%");
            }else{
                $spells->where('tier','LIKE',"%" .request()->tier."%");
            }
        }
        if(request()->archetypes){
            if(empty($spells)){
                $spells = Spell::where('archetypes', 'LIKE', "%" .request()->archetypes ."%");
            }else{
                $spells->where('archetypes', 'LIKE', "%" .request()->archetypes ."%");
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

        $resolver = new AbsoluteUrlResolver(url('/'));
        $extension = new LeagueCommonMarkObsidianExtension(
            attachmentLinkResolver: $resolver,
            internalLinkResolver: $resolver,
        );

        $environment = new \League\CommonMark\Environment\Environment;
        $environment->addExtension(new \League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension);
        $environment->addExtension($extension);

        $converter = new \League\CommonMark\MarkdownConverter($environment);

        $gtp = new AnchorTagParser("/glossary");

        if(isset($spells)){
            return view('spell.index', ['spells'=>$spells->get(),'converter'=>$converter, 'ctp'=>$gtp]);
        }
        return view('spell.index', ['spells'=>Spell::get(),'converter'=>$converter, 'ctp'=>$gtp]);
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
        $spell->ctp = new AnchorTagParser("/glossary");
        
        return view('spell.view',$spell);
    }

}
