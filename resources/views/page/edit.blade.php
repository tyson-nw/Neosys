@extends('app')

@section('main')
    <h1 class='text-3xl'> Edit Page</h1>
    <form method='POST' action="/page/{{$slug}}/edit">
        <div class='mx-10 my-3'>
            @csrf
            @method('PATCH')
            
            @if($errors->any())
                <ul class='mx-auto background-yellow-100'>
                @foreach($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
                </ul>
            @endif
            
            <div>

                <input type='hidden' name='id' value='{{$id}}' />

                <div>
                    <label for='title'>Page Title</label>
                </div>
                
                <input class='w-full' type='text' name='title' id='title' value='{{ old("title", $title)}}' />
                @error('title')
                    <p>{{$message}}</p>
                @enderror
                @error('slug')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='license'>License</label>
                </div>
                <input class='w-full' type='text' name='license' id='license' value='{{ old("license", $license)}}' />
                @error('license')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>        
                <div>
                    <label for='content'>Page Contents</label>   
                </div>
                @error('content')
                    <p>{{$message}}</p>
                @enderror
                <div>
                    <textarea class='w-full min-h-screen' name='content' id='content' >{{ old("content", $content)}}</textarea>
                </div>
            </div>
            <div>
                <button type='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Update Page</button>
            </div>
        </div>
    </form>
@endsection