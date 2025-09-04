@extends('layouts.main')

@section('content')
    <div class="game-container" style="background-image: url({{ $def ? asset('storage/img/default.jpg') : asset('storage/' . $place->image) }})">
        <div class="inner-container">
            <h2 class="place-name">{{$place->name}}</h2>
            <div class="characters">
                <table class="hero-table {{ $enemyHP == 0 ? 'winner' : '' }} {{ $heroHP == 0 ? 'loser' : '' }}">
                    <tr>
                        <th>Name</th>
                        <th>Def.</th>
                        <th>Str.</th>
                        <th>Acc.</th>
                        <th>Mag.</th>
                        <th>HP</th>
                    </tr>
                    <tr>
                        <td>{{ $hero->name }}</td>
                        <td>{{ $hero->defence }}</td>
                        <td>{{ $hero->strength }}</td>
                        <td>{{ $hero->accuracy }}</td>
                        <td>{{ $hero->magic }}</td>
                        <td>{{ $heroHP }}</td>
                    </tr>
                </table>
                <p id="versus">VS</p>
                <table class="{{ $enemyHP == 0 ? 'loser' : '' }} {{ $heroHP == 0 ? 'winner' : '' }}">
                    <tr>
                        <th>Name</th>
                        <th>Def.</th>
                        <th>Str.</th>
                        <th>Acc.</th>
                        <th>Mag.</th>
                        <th>HP</th>
                    </tr>
                    <tr>
                        <td>{{ $enemy->name }}</td>
                        <td>{{ $enemy->defence }}</td>
                        <td>{{ $enemy->strength }}</td>
                        <td>{{ $enemy->accuracy }}</td>
                        <td>{{ $enemy->magic }}</td>
                        <td>{{ $enemyHP }}</td>
                    </tr>
                </table>
            </div>
            <div class="history-container">
                <div class="history">
                    @if (count($historyArr) !== 0)
                        @for ($i = count($historyArr)-1; $i >= 0; $i--)
                            <p class="history-entry">{{$i + 1}}. {{$historyArr[$i]}}</p>
                        @endfor
                    @else
                        <p class="history-entry">No history yet</p>
                    @endif
                </div>
            </div>
            <div class="gamebuttons game-page">
                @if ($contest->win !== null)
                    @if (auth()->user()->admin && $hero->user_id != auth()->user()->id)
                        <p id="endgame">{{ $contest->win ? 'The user won' : 'The user lost' }}</p>
                    @else
                        <p id="endgame">{{ $contest->win ? 'You won!' : 'You lost.' }}</p>
                    @endif
                @elseif ($nocontinue)
                    <p id="endgame">Cannot continue this match. (Opponent deleted)</p>
                @else
                    <a class="button" href="{{ route('contests.attack', ['contest' => $contest, 'type' => 'melee']) }}">Melee</a>
                    <a class="button" href="{{ route('contests.attack', ['contest' => $contest, 'type' => 'ranged']) }}">Ranged</a>
                    <a class="button" href="{{ route('contests.attack', ['contest' => $contest, 'type' => 'special']) }}">Special</a>
                @endif
            </div>
        </div>
    </div>

@endsection
