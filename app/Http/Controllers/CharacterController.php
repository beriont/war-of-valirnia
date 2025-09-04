<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Place;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CharacterController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $characters = Auth::user()->characters;
        $heroes = $characters->where('enemy', false);
        $enemies = $characters->where('enemy', true);
        return view('characters.index', ['characters' => $characters, 'heroes' => $heroes, 'enemies' => $enemies]);
    }
    public function show(Character $character)
    {
        $this->authorize('view', $character);
        $enemies = [];
        $places = [];
        foreach ($character->contests as $contest) {
            $enemyID = DB::table('character_contest')
            ->where('contest_id', $contest->id)
            ->where('character_id', '!=', $character->id)
            ->value('character_id'); // NAGYON CSÚNYA :( nem tudom hogy lehet szebben
            $enemy = Character::withTrashed()->find($enemyID);
            if ($enemy !== null) {
                array_push($enemies, $enemy->name);
            } else {
                array_push($enemies, 'Unknown');
            }
            $place = Place::withTrashed()->find($contest->place_id);
            if ($place !== null) {
                array_push($places, $place->name);
            } else {
                array_push($places, 'Unknown');
            }
        }
        return view('characters.show', [ 'character' => $character, 'enemies' => $enemies, 'places' => $places ]);
    }
    public function create()
    {
        return view('characters.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:characters',
            'defence' => 'required|integer|min:0|max:3',
            'strength' => 'required|integer|min:0|max:20',
            'accuracy' => 'required|integer|min:0|max:20',
            'magic' => 'required|integer|min:0|max:20',
            'sum' => ['sometimes', function ($attribute, $value, $fail) use ($request) {
                $total = $request->input('defence', 0) + $request->input('strength', 0) + $request->input('accuracy', 0) + $request->input('magic', 0);
                if ($total > 20) {
                    $fail('The sum of the powers cannot be more than 20.');
                }
            }]
        ], [
            'name.required' => 'You have to name your character.',
            'name.unique' => 'A character with this name already exists.',
            'defence.*' => 'Please enter a whole number between 0 and 3.',
            'strength.*' => 'Please enter a whole number between 0 and 20.',
            'accuracy.*' => 'Please enter a whole number between 0 and 20.',
            'magic.*' => 'Please enter a whole number between 0 and 20.',
            'sum.*' => 'The sum of the powers cannot be more than 20.'
        ]);
        if ($request->has('enemy')) $validated['enemy'] = true;
        $validated['user_id'] = Auth::id();
        $character = Character::create($validated);
        return redirect() -> route('characters.show', ['character' => $character]);
    }
    public function destroy(Character $character)
    {
        $this -> authorize('delete', $character);
        $character -> delete();
        return redirect() -> route('characters.index');
    }
    public function edit(Character $character)
    {
        $this -> authorize('update', $character);
        return view('characters.edit', ['character' => $character]);
    }
    public function update(Request $request, Character $character)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('characters')->ignore($character->id),
            ],
            'defence' => 'required|integer|min:0|max:3',
            'strength' => 'required|integer|min:0|max:20',
            'accuracy' => 'required|integer|min:0|max:20',
            'magic' => 'required|integer|min:0|max:20',
            'sum' => ['sometimes', function ($attribute, $value, $fail) use ($request) {
                $total = $request->input('defence', 0) + $request->input('strength', 0) + $request->input('accuracy', 0) + $request->input('magic', 0);
                if ($total > 20) {
                    $fail('The sum of the powers cannot be more than 20.');
                }
            }]
        ], [
            'name.required' => 'You have to name your character.',
            'name.*' => 'A character with this name already exists.',
            'defence.*' => 'Please enter a whole number between 0 and 3.',
            'strength.*' => 'Please enter a whole number between 0 and 20.',
            'accuracy.*' => 'Please enter a whole number between 0 and 20.',
            'magic.*' => 'Please enter a whole number between 0 and 20.',
            'sum.*' => 'The sum of the powers cannot be more than 20.'
        ]);
        if ($character->enemy) $validated['enemy'] = true;
        else $validated['enemy'] = false;
        $character->update($validated);
        return redirect() -> route('characters.show', ['character' => $character]);
    }
}
