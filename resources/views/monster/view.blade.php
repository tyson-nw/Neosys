@extends('app')

@section('main')
<div class='mb-2 monster'>
    <h1 class='text-3xl m-2'>{{$title}}</h1>
    <div class='mx-10 my-3'>
        {!! $html !!}   
    </div>
    <div class='text-xs container'><div class='m-3'>{{$license}}</div> <div class='m-3'>Source: <a href="sources/{{Str::slug($source)}}" >{{$source}} </a></div></div>
</div>
@endsection