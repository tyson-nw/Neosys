@extends('app')

@section('main')

<div class='spell'>
    <h1 class='text-6xl m-2'>{{$title}}</h1>
    @if( session()->has('spell_updated'))
        <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>{{session('spell_updated')}}</div>
    @endif
    @can('update_spell')
        <div>
            <a href="/spell/{{$slug}}/edit" class='rounded-full bg-blue-300 p-1 px-3 m-1'>Edit this spell...</a>
        </div>
    @endcan

    <ul class='mx-10 my-3'>
        <li>
            <strong>
                @if($tier=="[[#Cantrip]]")
                    <a href='#cantrip' card="Cantrip">Cantrip</a>
                @else
                    Tier {{$tier}}
                @endif
            </strong> 
            {!! $ctp( implode(", ",json_decode($archetypes, TRUE)))!!} 
        </li>
        <li><strong>Casting Time</strong> {!! $ctp(implode(", ",json_decode($casting_time, TRUE)))!!}</li>
        <li>
            <strong>Target</strong>
            {!! $ctp(implode(", ",json_decode($target, TRUE)))!!}
            @isset($defense)
                , {!! $ctp($defense)!!}
            @endisset
        </li>
        @isset($duration)
            <li>
                <strong>Duration</strong>
                {!! $ctp($duration)!!}
                
                @if($concentration)
                    , <a href="#" card="Concentration">Concetration</a>
                @endif
            </li>
        @endisset
            <li>{!! $ctp($details)!!}</li>
        @isset($higher_cast)
            <li>{!! $ctp($higher_cast)!!}</li>
        @endisset
            <li class='text-xs container'><div class='m-3'>Source: <a href="/source/{{Str::slug($source)}}" >{{$source}} </a></div></li>
    </ul>
</div>
@endsection