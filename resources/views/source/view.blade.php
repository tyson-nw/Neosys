@extends('app')

@section('main')

    <div class='title text-6xl'>{{$title}}</div>
    
    <div class=''>
        {!! $content !!}
    </div>
    
@endsection