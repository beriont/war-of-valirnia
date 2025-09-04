@extends('layouts.main')

@section('content')
<h2>Create new character</h2>
<form action="{{ route('characters.store') }}" method="POST">
    @csrf

    Name:<br>
    <input type="text" name="name" value="{{ old('name', '') }}">
    @error('name')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    @if(auth()->user()->admin)
        <input type="checkbox" name="enemy" {{ old('enemy', '') ? 'checked' : '' }}>Enemy<br>
    @endif
    <br>
    Defence:<br>
    <input type="number" name="defence" value="{{ old('defence', '') }}">
    @error('defence')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Strength:<br>
    <input type="number" name="strength" value="{{ old('strength', '') }}">
    @error('strength')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Accuracy:<br>
    <input type="number" name="accuracy" value="{{ old('accuracy', '') }}">
    @error('accuracy')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Magic:<br>
    <input type="number" name="magic" value="{{ old('magic', '') }}">
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
