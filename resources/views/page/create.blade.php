@extends('app')

@section('scripts')
<script src="{{ mix('js/editor.js') }}" defer></script>
@endsection

@section('main')
    <h1 class='text-3xl'> Create Page</h1>
    <form method='POST' action='/pages/create' id="form" >
        <div class='mx-10 my-3'>
            @csrf


            @if($errors->any())
                <ul class='mx-auto background-yellow-100'>
                @foreach($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
                </ul>
            @endif
            <div>
                <div>
                    <label for='title'>Page Title</label>
                </div>

                <input class='w-full' type='text' name='title' id='title' value='{{ old("title")}}' />
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
                <input class='w-full' type='text' name='license' id='license' value='{{ old("license")}}' />
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
                <textarea class='hidden' name="content" id="content">{{ old("content")}}</textarea>
                <div>
                    <div id="editor"><div>
                </div>
            </div>
            <div>
                <button id='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Create Page</button>
            </div>
        </div>
    </form>
@endsection
