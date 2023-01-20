@extends('app')

@section('main')

<div class='border flex flex-row items-center'>
    <h1 class="text-3xl m-2 basis-3/5" >Monsters</h1>
</div>

<ul class='m-5 mx-8' >
    @foreach($monsters as $monster)
        <li>
            <details class='mb-2 monster'>
                <summary class='border flex flex-row p-2  items-center'>
                    <div class='basis-4/5'><a href='/monster/{{$monster->slug}}' class='underline text-xl'>{{$monster->title}}</a> </div>
                </summary>
                <div class='mx-10 my-3'>
                    {!! $atp($converter->convert($monster->content)) !!}
                    <div class='text-xs container'><div class='m-3'>{{$monster->license}}</div> <div class='m-3'>Source: <a href="sources/{{$monster->source_slug}}" >{{$monster->source}} </a></div></div>
                </div>
            </details>
        </li>
    @endforeach
</ul>
@endsection