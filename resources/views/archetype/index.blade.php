@extends('app')

@section('main')

<div class='border flex flex-row items-center'>
    <h1 class="text-6xl m-2 basis-3/5" >Archetypes</h1>
</div>

<ul class='m-5 mx-8' >
    @foreach($archetypes as $archetype)
        <li>
            <details class='mb-2 monster'>
                <summary class='border flex flex-row p-2  items-center'>
                    <div class='basis-4/5'><a href='/archetype/{{$archetype->slug}}' class='underline text-xl'>{{$archetype->title}}</a> </div>
                </summary>
            </details>
        </li>
    @endforeach
</ul>
@endsection