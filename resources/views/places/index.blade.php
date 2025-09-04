@extends('layouts.main')

@section('content')
    <h2>Places</h2>
    @unless($places->isEmpty())
        <table>
            <tr>
                <th>Name</th>
                <th>Picture</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach ($places as $place)
                <tr>
                    <td>{{ $place->name }}</td>
                    <td class="image"><img src="{{ asset('storage/' . $place->image) }}" alt=""></td>
                    <td><a href="{{ route('places.edit', ['place' => $place]) }}" class="redlink">Edit</a></td>
                    <td><form action="{{ route('places.destroy', ['place' => $place]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <a href="#" onclick="this.closest('form').submit()" class="redlink">Delete</a>
                    </form></td>
                </tr>
            @endforeach
        </table>
    @else
        <h3>You have no places yet.</h3>
    @endunless
    <div class="gamebuttons">
        <a href="{{ route('places.create') }}" class="button">Add place</a>
    </div>

@endsection
