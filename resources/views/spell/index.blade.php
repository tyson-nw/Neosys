@extends('app')

@section('main')
<h1 class="text-3xl m-2" >Spells</h1>
@if( session()->has('spell_created'))
    <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
        <a href="/page/{{session('spell_created')['slug'] }}">{{session('spell_created')['title'] }}</a> has been created.
    </div>
@endif
@if( session()->has('spell_deleted'))
    <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
        {{session('spell_deleted')['title'] }} has been deleted.
    </div>
@endif

@can('create_page')
<div>
    <a href='/spells/create' class='rounded-full bg-blue-300 p-1 px-3 m-1'>Create a new spell</a>
</div>
@endcan

<ul class='list-disc m-5 mx-8' >
    @foreach($spells as $spell)
        <li>
            <a href='/spell/{{$spell->slug}}' class='underline text-xl'>{{$spell->title}}</a> 
            @can('delete_page')
                <form method='POST' action='/spell/{{$spell->slug}}' class='inline'> @csrf @method('delete') <button type='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Delete</button>
            @endcan
        </form>
    @endforeach
</ul>
@endsection