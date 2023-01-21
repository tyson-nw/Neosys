@extends('app')

@section('main')
<div class='source'>
    <div class='title text-6xl'>{{$title}}</div>
    
    <div class=''>
        {!! $html !!}
    </div>
</div>
@endsection