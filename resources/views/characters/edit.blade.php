@extends('layouts.main')

@section('content')
<h2>Edit character</h2>
<form action="{{ route('characters.update', ['character' => $character]) }}" method="POST">
    @csrf
    @method('PATCH')

    Name:<br>
    <input type="text" name="name" value="{{ old('name', $character->name) }}">
    @error('name')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    <br>
    Defence:<br>
    <input type="number" name="defence" value="{{ old('defence', $character->defence) }}">
    @error('defence')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Strength:<br>
    <input type="number" name="strength" value="{{ old('strength', $character->strength) }}">
    @error('strength')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Accuracy:<br>
    <input type="number" name="accuracy" value="{{ old('accuracy', $character->accuracy) }}">
    @error('accuracy')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Magic:<br>
    <input type="number" name="magic" value="{{ old('magic', $character->magic) }}">
    @error('magic')
        <span class="error">{{ $message }}</span>
    @enderror
    <br><br>
    <input type="hidden" name="sum">
    @error('sum')
        <span class="error">{{ $message }}</span>
        <br>
    @enderror

    <button class="button" type="submit">Save</button>
</form>
@endsection
