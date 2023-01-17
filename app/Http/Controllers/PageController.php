<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;

use App\Models\Page;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.index', ['pages'=>Page::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.create',['action'=>'/pages/create','act'=>'Create']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePageRequest $request)
    {

        $valid = $request->validated();

        Page::create($valid);

        return redirect('/pages')->with('page_created', ['title'=>$valid['title'], 'slug'=>$valid['slug']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('page.view',$page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        session()->put('_old_input', $page);
        $page->action = "/page/{$page->slug}/edit";
        $page->act = "Edit";
        return view('page.create',$page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePageRequest  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->title =$request->title;
        $page->slug =$request->slug;
        $page->license =$request->license;
        $page->content =$request->content;
        $page->save();
        session()->flash('page_updated', 'Page Updated');
        return redirect("/page/{$page->slug}");        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        session()->flash('page_deleted', ['title'=>$page['title'], 'slug'=>$page['slug']]);
        $page->delete();
        return redirect('/pages');
    }
}
