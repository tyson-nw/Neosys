<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMonsterRequest;
use App\Http\Requests\UpdateMonsterRequest;
use App\Models\Monster;
use App\Tools\AnchorTagParser;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\MarkdownConverter;

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


        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL,
                'aria_hidden' => true,
            ],
        ];

        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new AutolinkExtension);
        $environment->addExtension(new HeadingPermalinkExtension());

        $converter = new MarkdownConverter($environment);

        $atp = new AnchorTagParser();

        if(isset($monsters)){
            return view('monster.index', ['monsters'=>$monsters->get(),'converter'=>$converter, 'atp'=>$atp]);
        }
        return view('monster.index', ['monsters'=>Monster::get(),'converter'=>$converter, 'atp'=>$atp]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monster  $monster
     * @return \Illuminate\Http\Response
     */
    public function show(Monster $monster)
    {
        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL,
                'aria_hidden' => true,
            ],
        ];
        
        $environment = new Environment($config);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new TableExtension);
        $environment->addExtension(new AutolinkExtension);
        $environment->addExtension(new HeadingPermalinkExtension());

        $converter = new MarkdownConverter($environment);

        $atp = new AnchorTagParser($monster->source_slug);
        
        $monster->content = $atp($converter->convert($monster->content));

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
