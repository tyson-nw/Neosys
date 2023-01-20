@extends('app')

@section('main')

    <div class='title text-3xl m-2'>{{$title}}</div>
    
    <div class='mx-10 my-10 py-10'>
        {!! $content !!}
    </div>
    
@endsection