@extends('layouts.main')

@section('content')
<h2>Create new place</h2>
<form action="{{ route('places.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    Name:<br>
    <input type="text" name="name" value="{{ old('name', '') }}">
    @error('name')
        <span class="error">{{ $message }}</span>
    @enderror
    <br>
    Image:<br>
    <input type="file" name="image">
    @error('image')
        <span class="error">{{ $message }}</span>
    @enderror
    <br><br>

    <button class="button" type="submit">Save</button>
</form>
@endsection
