@extends('app')

@section('main')
<h1 class="text-6xl m-2" >Sources</h1>

<ul class='list-disc m-5 mx-8' >
    @foreach($sources as $source)
        <li>
            <a href='/source/{{$source->slug}}' class='underline text-xl'>{{$source->title}}</a> 
        </form>
    @endforeach
</ul>
@endsection