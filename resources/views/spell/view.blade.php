@extends('app')

@section('main')

    <h1 class='text-3xl m-2'>{{$title}}</h1>
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
                @if($tier=="Cantrip")
                    {{$tier}}
                @else
                    Tier {{$tier}}
                @endif
            </strong> 
            {{implode(", ", json_decode($classes))}} 
        </li>
        <li><strong>Casting Time</strong> {{$casting_time}}</li>
        <li>
            <strong>Target</strong>
            @isset($defense)
                , {{$defense}}
            @endisset
        </li>
        @isset($duration)
            <li>
                <strong>Duration</strong>
                {{$duration}}
                @if($concentration)
                    , Concetration
                @endif
            </li>
        @endisset
            <li>{{$details}}</li>
        @isset($higher_cast)
            <li>{{$higher_cast}}</li>
        @endisset
    
    </ul>
    
@endsection