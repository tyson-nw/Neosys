@extends('app')

@section('main')
    <h1> {{$act}} Page</h1>
    <form method='POST' action={{$action}}>
        <div>
            @csrf
            @if($act == 'Edit')
                @method('PATCH')
            @endif
            @if($errors->any())
                <ul>
                @foreach($errors->all() as $error)
                    <li> {{$error}} </li>
                @endforeach
                </ul>
            @endif
            <div>
                @isset($id)
                    <input type='hidden' name='id' value='{{$id}}' />
                @endisset
                <label for='title'>Page Title</label>
                <input class='' type='text' name='title' id='title' value='{{ old("title")}}' />
                @error('title')
                    <p>{{$message}}</p>
                @enderror
                @error('slug')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for='license'>License</label>
                <input class='' type='text' name='license' id='license' value='{{ old("license")}}' />
                @error('license')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for='content'></label>
                @error('content')
                    <p>{{$message}}</p>
                @enderror
                <textarea class='' name='content' id='content' >{{ old("content")}}</textarea>
            </div>
            <div>
                <input class='' type='submit' value='submit page'/>
            </div>
        </div>
    </form>
@endsection