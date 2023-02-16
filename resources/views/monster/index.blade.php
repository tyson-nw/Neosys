@extends('app')

@section('main')

<div class='border flex flex-row items-center'>
    <h1 class="text-6xl m-2 basis-3/5" >Monsters</h1>
</div>

<details id='filters' class='border p-3'>
    <summary>
        Filters
    </summary>
    <div>
        <form>
            <div>
                <label>Size</label>
                <select name='size' id='size'>
                    <option value='' @empty( request()->size =='') selected @endempty></option>
                    <option value='[[#Tiny]]' @if(request()->size=='[[#Tiny]]') selected @endif>Tiny</option>
                    <option value='[[#Small]]' @if(request()->size=='[[#Small]]') selected @endif>Small</option>
                    <option value='[[#Medium]]' @if(request()->size=='[[#Medium]]') selected @endif>Medium</option>
                    <option value='[[#Large]]' @if(request()->size=='[[#Large]]') selected @endif>Large</option>
                    <option value='[[#Huge]]' @if(request()->size=='[[#Huge]]') selected @endif>Huge</option>
                </select>
            </div>
            <div>
                <label>Type</label>
                <select name='type' id='type'>
                    <option value='' @empty( request()->type =='') selected @endempty></option>
                    <option value='[[#Beast]]' @if(request()->type=='[[#Beast]]') selected @endif>Beast</option>
                    <option value='[[#Elemental]]' @if(request()->type=='[[#Elemental]]') selected @endif>Elemental</option>
                    <option value='[[#Dragon]]' @if(request()->type=='[[#Dragon]]') selected @endif>Dragon</option>
                    <option value='[[#Giant]]' @if(request()->type=='[[#Giant]]') selected @endif>Giant</option>
                    <option value='[[#Goblinoid]]' @if(request()->type=='[[#Goblinoid]]') selected @endif>Goblinoid</option>
                    <option value='[[#Humanoid]]' @if(request()->type=='[[#Humanoid]]') selected @endif>Humanoid</option>
                    <option value='[[#Monstrosity]]' @if(request()->type=='[[#Monstrosity]]') selected @endif>Monstrosity</option>
                    <option value='[[#Outsider]]' @if(request()->type=='[[#Outsider]]') selected @endif>Outsider</option>
                    <option value='[[#Plant]]' @if(request()->type=='[[#Plant]]') selected @endif>Plant</option>
                    <option value='[[#Undead]]' @if(request()->type=='[[#Undead]]') selected @endif>Undead</option>
                </select>
            </div>
            <div>
                <label for='challenge'>Challenge</label>
                <select name='challenge' id='challenge'>
                    <option value='' @empty( request()->type =='') selected @endempty></option>
                    <option value='[[#Challenge]] 1' @if(request()->challenge=='[[#Challenge]] 1') selected @endif>Challenge 1</option>
                    <option value='[[#Challenge]] 2' @if(request()->challenge=='[[#Challenge]] 2') selected @endif>Challenge 2</option>
                    <option value='[[#Challenge]] 3' @if(request()->challenge=='[[#Challenge]] 3') selected @endif>Challenge 3</option>
                    <option value='[[#Challenge]] 4' @if(request()->challenge=='[[#Challenge]] 4') selected @endif>Challenge 4</option>
                    <option value='[[#Challenge]] 5' @if(request()->challenge=='[[#Challenge]] 5') selected @endif>Challenge 5</option>
                    <option value='[[#Challenge]] 6' @if(request()->challenge=='[[#Challenge]] 6') selected @endif>Challenge 6</option>
                </select>
            <div>
                <label for='bonus_action'>Bonus Actions</label>
                <input type='checkbox' name='bonus_action' @isset(request()->bonus_action) checked @endisset />
            </div>
            <div>
                <label for='responses'>Responses</label>
                <select name='responses' id='responses'>
                    <option value='' @empty( request()->type =='') selected @endempty></option>
                    <option value='**Responses** 1' @if(request()->responses=='**Responses** 1') selected @endif>Responses 1</option>
                    <option value='**Responses** 2' @if(request()->responses=='**Responses** 2') selected @endif>Responses 2</option>
                    <option value='**Responses** 3' @if(request()->responses=='**Responses** 3') selected @endif>Responses 3</option>
                </select>
            </div>
            <div>
                <label for='lair_act'>Lair Acts</label>
                <input type='checkbox' name='lair_act' @isset(request()->lair_act) checked @endisset />
            </div>
            <button>Filter</button>
        </form>
    </div>
</details>

<ul class='m-5 mx-8' >
    @foreach($monsters as $monster)
        <li>
            <details class='mb-2 monster'>
                <summary class='border flex flex-row p-2  items-center'>
                    <div class='basis-4/5'><a href='/monster/{{$monster->slug}}' class='underline text-xl'>{{$monster->title}}</a> </div>
                </summary>
                <div class='mx-10 my-3'>
                    {!! $monster->html !!}
                    <div class='text-xs flex justify-between'>
                        <div class='m-3'>Source: <a href="/source/{{Str::slug($monster->source)}}" >{{$monster->source}} </a></div>
                        <div class='m-3'>{{$monster->license}}</div>
                    </div>
                </div>
            </details>
        </li>
    @endforeach
</ul>
@endsection