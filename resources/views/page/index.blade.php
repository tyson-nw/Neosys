@extends('app')

@section('main')
<h1 class="text-3xl font-bold underline" >Pages</h1>
<div><a href='/pages/create'>Create new page</a></div>
    @if( session()->has('page_created'))
        <a href="/page/{{session('page_created')['slug'] }}">{{session('page_created')['title'] }}</a> has been created.
    @endif
    @if( session()->has('page_deleted'))
        {{session('page_deleted')['title'] }} has been deleted.
    @endif
<ul>
    @foreach($pages as $page)
        <li><a href='/page/{{$page->slug}}'>{{$page->title}}</a> <form method='POST' action='/page/{{$page->slug}}'> @csrf @method('delete') <button type='submit'>Delete</button></form>
    @endforeach
</ul>
@endsection