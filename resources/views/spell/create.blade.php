@extends('app')

@section('main')
    <h1 class='text-3xl'> Create Spell</h1>
    <form method='POST' action='/spells/create' id="form">
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
                    <label for='title'>Spell Title</label>
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
                    <label for='tier'>Tier</label>
                </div>
                <input class='w-full' type='text' name='tier' id='tier' value='{{ old("tier")}}' />
                @error('tier')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='classes'>Classes</label>
                </div>
                <input class='w-full' type='text' name='classes' id='classes' value='{{ old("classes")}}' />
                @error('classes')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='casting_time'>Casting Time</label>
                </div>
                <input class='w-full' type='text' name='casting_time' id='casting_time' value='{{ old("casting_time")}}' />
                @error('casting_time')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='target'>Target</label>
                </div>
                <input class='w-full' type='text' name='target' id='target' value='{{ old("target")}}' />
                @error('target')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='defense'>Defense</label>
                </div>
                <input class='w-full' type='text' name='defense' id='defense' value='{{ old("defense")}}' />
                @error('defense')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <div>
                    <label for='details'>Details</label>
                </div>
                
                @error('details')
                    <p>{{$message}}</p>
                @enderror

                <textarea class='w-full' name='details' id='details'>{{ old("details")}}</textarea>
            </div>
            <div>
                <div>
                    <label for='higher_cast'>Higher Cast</label>
                </div>
                <input class='w-full' type='text' name='higher_cast' id='higher_cast' value='{{ old("higher_cast")}}' />
                @error('higher_cast')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <div>
                <button id='submit' class='rounded-full bg-blue-300 p-1  px-3 m-1'>Create Spell</button>
            </div>
        </div>
    </form>
@endsection