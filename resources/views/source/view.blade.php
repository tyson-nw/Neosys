@extends('app')

@section('main')
<div class='source'>
    <div class='title text-6xl'>{{$title}}</div>
    
    <div class=''>
        {!! $content !!}
    </div>
</div>
@endsection