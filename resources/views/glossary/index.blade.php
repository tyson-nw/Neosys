@extends('app')

@section('main')
<h1> Glossary </h1>
<dl>
    @php
        $current = "";
    @endphp
    @foreach($cards as $card)
        @if($current != $card->title)
            <dt class='font-extrabold underline mt-3'><a id="content-{{$card->slug}}">{{$card->title}}</a></dt>
            @php
                $current = $card->title;
            @endphp
        @endif
        <dd>{!!$card->html!!} (<span class='text-xs'>Source: <a href="/source/{{$card->source_slug}}" >{{$card->source}} </a></span>) </dd>
    @endforeach
</dl>
@endsection