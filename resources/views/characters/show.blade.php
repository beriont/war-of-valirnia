@extends('layouts.main')

@section('content')
    <h2>{{ $character->name }}</h2>
    <h3>Stats:</h3>
    <p class="showpage"><b>Type:</b> {{$character->enemy ? 'Enemy' : 'Hero'}}</p>
    <p class="showpage"><b>Defence:</b> {{$character->defence}}</p>
    <p class="showpage"><b>Strength:</b> {{$character->strength}}</p>
    <p class="showpage"><b>Accuracy:</b> {{$character->accuracy}}</p>
    <p class="showpage"><b>Magic:</b> {{$character->magic}}</p>
    <div class="gamebuttons">
        @unless ($character->enemy)
            <a href="{{ route('contests.create', ['character' => $character]) }}" class="button">New match</a>
        @endunless
        @can('update', $character)
            <a href="{{ route('characters.edit', ['character' => $character]) }}" class="button">Edit</a>
        @endcan
        @can ('delete', $character)
            <form action="{{ route('characters.destroy', ['character' => $character]) }}" method="POST" class="formbutton">
                @csrf
                @method('DELETE')
                <a href="#" onclick="this.closest('form').submit()" class="button">Delete</a>
            </form>
        @endcan
    </div>
    @unless ($character->enemy)
        <p class="showpage"><b>Matches played:</b></p>
        <ul>
            @forelse ($character->contests as $contest)
                <li><a href="{{ route('contests.show', ['contest' => $contest]) }}" class="redlink">{{$places[$loop->index]}} - {{$enemies[$loop->index]}}</a></li>
            @empty
                <p>No matches yet.</p>
            @endforelse
        </ul>
    @endunless
@endsection
