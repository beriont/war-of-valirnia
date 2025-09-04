@extends('layouts.main')

@section('content')
    <h2>Your heroes</h2>
    @unless($heroes->isEmpty())
        <table>
            <tr>
                <th>Name</th>
                <th>Defence</th>
                <th>Strength</th>
                <th>Accuracy</th>
                <th>Magic</th>
                <th>Details</th>
            </tr>
            @foreach ($heroes as $character)
                <tr>
                    <td>{{ $character->name }}</td>
                    <td>{{ $character->defence }}</td>
                    <td>{{ $character->strength }}</td>
                    <td>{{ $character->accuracy }}</td>
                    <td>{{ $character->magic }}</td>
                    <td><a href="{{ route('characters.show', ['character' => $character]) }}" class="redlink">Details</a></td>
                </tr>
            @endforeach
        </table>
    @else
        <h3>You have no heroes yet.</h3>
    @endunless
    @if (auth()->user()->admin)
        <h2>Enemy characters</h2>
        @unless($enemies->isEmpty())
            <table>
                <tr>
                    <th>Name</th>
                    <th>Defence</th>
                    <th>Strength</th>
                    <th>Accuracy</th>
                    <th>Magic</th>
                    <th>Details</th>
                </tr>
                @foreach ($enemies as $character)
                    <tr>
                        <td>{{ $character->name }}</td>
                        <td>{{ $character->defence }}</td>
                        <td>{{ $character->strength }}</td>
                        <td>{{ $character->accuracy }}</td>
                        <td>{{ $character->magic }}</td>
                        <td><a href="{{ route('characters.show', ['character' => $character]) }}" class="redlink">Details</a></td>
                    </tr>
                @endforeach
            </table>
        @else
            <h3>No enemy characters found.</h3>
        @endunless
    @endif
    <div class="gamebuttons">
        <a href="{{ route('characters.create') }}" class="button">Add character</a>
    </div>
@endsection
