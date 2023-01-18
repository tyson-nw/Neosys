@extends('app')

@section('main')

    <h1 class='text-3xl m-2'>{{$title}}</h1>
    @if( session()->has('page_updated'))
        <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>{{session('page_updated')}}</div>
    @endif
    @can('update_page')
        <div>
            <a href="/page/{{$slug}}/edit" class='rounded-full bg-blue-300 p-1 px-3 m-1'>Edit this page...</a>
        </div>
    @endcan

    <div class='mx-10 my-3'>
        {{$content}}
    </div>
    
@endsection