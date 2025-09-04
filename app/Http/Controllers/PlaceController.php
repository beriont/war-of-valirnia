<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Place::class);
        return view('places.index', ['places' => Place::all()]);
    }
    public function create()
    {
        $this->authorize('create', Place::class);
        return view('places.create');
    }
    public function store(Request $request)
    {
        $this->authorize('create', Place::class);
        $validated = $request->validate([
            'name' => 'required|unique:places',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'You have to name the place.',
            'name.unique' => 'A place with this name already exists.',
            'image.required' => 'Please upload an image file.',
            'image.image' => 'Please upload an image file.',
            'image.mimes' => 'Image format incorrect. (Accepted types: jpeg,jpg,png,gif)',
            'image.max' => 'File size too big. (Max. 2MB)'
        ]);
        $validated['image'] = Storage::disk('public')->put('img', $request->file('image'));
        $place = Place::create($validated);
        return redirect() -> route('places.index');
    }
    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);
        Storage::disk('public')->delete($place->image);
        $place -> delete();
        return redirect() -> route('places.index');
    }
    public function edit(Place $place)
    {
        $this -> authorize('update', $place);
        return view('places.edit', ['place' => $place]);
    }
    public function update(Request $request, Place $place)
    {
        $this->authorize('update', $place);
        $validated = $request->validate([
            'name' => 'required|unique:places',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'You have to name the place.',
            'name.unique' => 'A place with this name already exists.',
            'image.image' => 'Please upload an image file.',
            'image.mimes' => 'Image format incorrect. (Accepted types: jpeg,jpg,png,gif)',
            'image.max' => 'File size too big. (Max. 2MB)'
        ]);
        if ($request->hasFile('image')) {
            $validated['image'] = Storage::disk('public')->put('img', $request->file('image'));
            Storage::disk('public')->delete($place->image);
        } else {
            $validated['image'] = $place->image;
        }
        $place->update($validated);
        return redirect() -> route('places.index');
    }
}
