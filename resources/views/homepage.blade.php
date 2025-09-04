@extends('layouts.main')

@section('content')
    <h2 class="slogan">A new challenge awaits you, fearless warrior.</h2>
    <p class="desc">In the War of Valirnia, no one is safe from the monsters lurking in the dark.</p>
    <p class="desc">Your objective is to defeat all the enemies that plagued this once peaceful nation, and restore the tranquility of Valirnia.</p>
    <p class="desc">Players have already created {{ $charactersCount }} characters, and played {{ $contestsCount }} matches. What are you waiting for? </p>
    <p class="desc">Join the fight!</p>
@endsection
