@extends('app')

@section('main')
<h1 class="text-3xl m-2" >Pages</h1>
@if( session()->has('page_created'))
    <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
        <a href="/page/{{session('page_created')['slug'] }}">{{session('page_created')['title'] }}</a> has been created.
    </div>
@endif
@if( session()->has('page_deleted'))
    <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
        {{session('page_deleted')['title'] }} has been deleted.
    </div>
@endif

@can('create_page')
<div>
    <a href='/pages/create' class='rounded-full bg-blue-300 p-1 px-3 m-1'>Create new page</a>
</div>
@endcan

<ul class='list-disc m-5 mx-8' >
    @foreach($pages as $page)
        <li>
            <a href='/page/{{$page->slug}}' class='underline text-xl'>{{$page->title}}</a> 
            @can('delete_page')
                <form method='POST' action='/page/{{$page->slug}}' class='inline'> @csrf @method('delete') <button type='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Delete</button>
            @endcan
        </form>
    @endforeach
</ul>
@endsection