@extends('app')

@section('main')

<div class='border flex flex-row items-center'>
    <h1 class="text-6xl m-2 basis-3/5" >Spells</h1>
    @if( session()->has('spell_created'))
        <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
            <a href="/page/{{session('spell_created')['slug'] }}">{{session('spell_created')['title'] }}</a> has been created.
        </div>
    @endif

    @can('create_page')
    <div class='basis-2/5 m-2 content-center'>
        <a href='/spells/create' class='rounded-full bg-blue-300 p-1 px-3 m-1'>Create a new spell</a>
    </div>
    @endcan
</div>

@if( session()->has('spell_deleted'))
    <div class='mx-auto bg-amber-200 border-amber-400 p-4 m-2 border-2 rounded-full'>
        {{session('spell_deleted')['title'] }} has been deleted.
    </div>
@endif

<details id='filters' class='border p-3'>
    <summary>
        Filters
    </summary>
    <div>
        <form>
            <div>
                <label>Tier</label>
                <select name='tier' id='tier'>
                    <option value='' @empty( request()->tier =='') selected @endempty></option>
                    <option value='Cantrip' @if(request()->tier=='Cantrip') selected @endif>Cantrip</option>
                    <option value='1' @if(request()->tier=='1') selected @endif>1</option>
                    <option value='2' @if(request()->tier=='2') selected @endif>2</option>
                    <option value='3' @if(request()->tier=='3') selected @endif>3</option>
                    <option value='4' @if(request()->tier=='4') selected @endif>4</option>
                </select>
            </div>
            <div>
                <label>Class</label>
                <select name='archetypes' id='archetypes'>
                    <option value='' @empty( request()->archetypes =='') selected @endempty></option>
                    <option value='Druid' @if(request()->archetypes=='Druid') selected @endif>Druid</option>
                    <option value='Dedicant' @if(request()->archetypes=='Dedicant') selected @endif>Dedicant</option>
                    <option value='God Touched' @if(request()->archetypes=='God-Touched') selected @endif>God Touched</option>
                    <option value='Paladin' @if(request()->archetypes=='Dedicant') selected @endif>Dedicant</option>
                    <option value='Wizard' @if(request()->archetypes=='Wizard') selected @endif>Wizard</option>
                </select>
            </div>
            <div>
                <label>Casting Time</label>
                <select name='casting_time' id='casting_time'>
                    <option value='' @empty( request()->casting_time =='') selected @endempty></option>
                    <option value='1 minute' @if(request()->casting_time=='1 minute') selected @endif>1 minute</option>
                    <option value='[[#Act]]' @if(request()->casting_time=='[[#Act]]') selected @endif>Act</option>
                    <option value='[[#Bonus Action]]' @if(request()->casting_time=='[[#Bonus Action]]') selected @endif>Bonus Action</option>
                    <option value='[[#Ritual]]' @if(request()->casting_time=='[[#Ritual]]') selected @endif>Ritual</option>
                </select>
            </div>
            <div>
                <label>Target</label>
                <select name='target' id='target'>
                    <option value='' @empty( request()->target =='') selected @endempty></option>
                    <option value='10 miles' @if(request()->target=='10 miles') selected @endif>10 miles</option>
                    <option value='[[#Aura]]' @if(request()->target=='[[#Aura]]') selected @endif>Aura</option>
                    <option value='[[#Circle]]' @if(request()->target=='[[#Circle]]') selected @endif>Circle</option>
                    <option value='[[#Cone]]' @if(request()->target=='[[#Cone]]') selected @endif>Cone</option>
                    <option value='[[#Line]]' @if(request()->target=='[[#Line]]') selected @endif>Line</option>
                    <option value='[[#Range]]' @if(request()->target=='[[#Range]]') selected @endif>Range</option>
                    <option value='[[#Sphere]]' @if(request()->target=='[[#Sphere]]') selected @endif>Sphere</option>
                    <option value='[[#Touch]]' @if(request()->target=='[[#Touch]]') selected @endif>Touch</option>
                </select>
            </div>
            <div>
                <label>Defense</label>
                <select name='defense' id='defense'>
                    <option value='' @empty( request()->defense =='') selected @endempty></option>
                    <option value='[[#Body]]' @if(request()->defense=='[[#Body]]') selected @endif>Body</option>
                    <option value='[[#Deflect]]' @if(request()->defense=='[[#Deflect]]') selected @endif>Deflect</option>
                    <option value='[[#Mind]]' @if(request()->defense=='[[#Mind]]') selected @endif>Mind</option>
                    <option value='[[#React]]' @if(request()->defense=='[[#React]]') selected @endif>React</option>
                </select>
            </div>
            <div>
                <label>Duration</label>
                <select name='duration' id='duration'>
                    <option value='' @empty( request()->duration =='') selected @endempty></option>
                    <option value='1 round' @if(request()->duration=='1 round') selected @endif>1 round</option>
                    <option value='1 minute' @if(request()->duration=='1 minute') selected @endif>1 minute</option>
                    <option value='10 minutes' @if(request()->duration=='10 minutes') selected @endif>10 minutes</option>
                    <option value='1 hour' @if(request()->duration=='1 hour') selected @endif>1 hour</option>
                    <option value='8 hours' @if(request()->duration=='8 hours') selected @endif>8 hours</option>
                </select>
            </div>
            <div>
                <label>Concentration</label>
                <input type='checkbox' name='concentration' @isset(request()->concentration) checked @endisset />
            </div>
            <div>
                <label>Casts at higher level</label>
                <input type='checkbox' name='higher_cast' @isset(request()->higher_cast) checked @endisset />
            </div>
                

            <button>Filter</button>
        </form>
    </div>
</details>

<ul class='m-5 mx-8' >
    @foreach($spells as $spell)
        <li>
            <details class='mb-2 spell'>
                <summary class='border flex flex-row p-2  items-center'>
                    <div class='basis-4/5'><a href='/spell/{{$spell->slug}}' class='underline text-xl'>{{$spell->title}}</a> </div>
                @can('delete_page')
                    <div class='basis-1/5'><form method='POST' action='/spell/{{$spell->slug}}' class='inline'> @csrf @method('delete') <button type='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Delete</button></div>
                @endcan
                </summary>
                <ul class='mx-10 my-3'>
                    <li>
                        <strong>
                            @if($spell->tier=="[[#Cantrip]]")
                                {!!$ctp($spell->tier)!!}
                            @else
                                Tier {{$spell->tier}}
                            @endif
                        </strong> 
                        {!!$ctp( implode(", ",json_decode($spell->archetypes, TRUE)))!!}
                    </li>
                    <li><strong>Casting Time</strong> {!!$ctp( implode(", ",json_decode($spell->casting_time, TRUE)))!!}</li>
                    <li>
                        <strong>Target</strong>
                        {!!$ctp( implode(", ",json_decode($spell->target, TRUE)))!!}
                        @isset($spell->defense)
                            , {!!$ctp( $spell->defense)!!}
                        @endisset
                    </li>
                    @isset($spell->duration)
                        <li>
                            <strong>Duration</strong>
                            {!!$ctp( $spell->duration)!!}
                            
                            @if($spell->concentration)
                                , <a href=#Concetration>Concetration</a>
                            @endif
                        </li>
                    @endisset
                        <li>{!!$ctp( $converter->convert($spell->details))!!}</li>
                    @isset($spell->higher_cast)
                        <li>{!!$ctp( $spell->higher_cast)!!}</li>
                    @endisset
                    <li class='text-xs container'><div class='m-3'>{{$spell->license}}</div> <div class='m-3'>Source: <a href="/source/{{Str::slug($spell->source)}}" >{{$spell->source}} </a></div></li>
                </ul>
            </details>
        </form>
    @endforeach
</ul>
@endsection