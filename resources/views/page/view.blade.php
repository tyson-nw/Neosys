@extends('app')

@section('main')
    @if( session()->has('page_updated'))
        <div>{{session('page_updated')}}</div>
    @endif
    @can('update_page')
        <div>
            <a href="/page/{{$slug}}/edit">Edit this page...</a>
        </div>
    @endcan
    <h1>{{$title}}</h1>
    {{$content}}
    
@endsection