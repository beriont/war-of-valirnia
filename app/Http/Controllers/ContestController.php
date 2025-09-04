<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Contest;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContestController extends Controller
{
    use AuthorizesRequests;
    public function show(Contest $contest)
    {
        $this->authorize('view', $contest);
        $contest = $contest->load('characters');
        $hero = $contest->characters->firstWhere('enemy', false);
        $enemy = $contest->characters->firstWhere('enemy', true);
        $nocontinue = false;
        if ($hero === null) {
            $heroID = DB::table('character_contest')
            ->where('contest_id', $contest->id)
            ->where('character_id', '!=', $enemy->id)
            ->value('character_id'); // NAGYON CSÚNYA :( nem tudom hogy lehet szebben
            $hero = Character::withTrashed()->find($heroID);
            $heroHP = $enemy->pivot->hero_hp;
            $enemyHP = $enemy->pivot->enemy_hp;
            $nocontinue = true;
        } else if ($enemy === null) {
            $enemyID = DB::table('character_contest')
            ->where('contest_id', $contest->id)
            ->where('character_id', '!=', $hero->id)
            ->value('character_id'); // NAGYON CSÚNYA :( nem tudom hogy lehet szebben
            $enemy = Character::withTrashed()->find($enemyID);
            $enemyHP = $hero->pivot->enemy_hp;
            $heroHP = $hero->pivot->hero_hp;
            $nocontinue = true;
        } else {
            $enemyHP = $hero->pivot->enemy_hp;
            $heroHP = $hero->pivot->hero_hp;
        }
        if ($contest->history !== "") {
            $historyArr = explode("\n", $contest->history);
        } else {
            $historyArr = [];
        }
        $place = Place::withTrashed()->find($contest->place_id);
        $def = false;
        if (!Storage::disk('public')->exists($place->image)) {
            $def = true;
        }
        return view('contests.show', [ 'contest' => $contest, 'place' => $place, 'def' => $def, 'hero' => $hero, 'heroHP' => $heroHP, 'enemy' => $enemy, 'enemyHP' => $enemyHP, 'historyArr' => $historyArr, 'nocontinue' => $nocontinue ]);
    }
    public function create(Character $character)
    {
        $data = [];
        $data['user_id'] = Auth::id();
        $data['place_id'] = rand(1, Place::all()->count());
        $data['win'] = null;
        $data['history'] = "";
        $data['characters'] = [$character->id];
        if ($character->enemy) {
            $enemyCharacter = Character::where('enemy', false)->inRandomOrder()->first();
        } else {
            $enemyCharacter = Character::where('enemy', true)->inRandomOrder()->first();
        }
        $data['enemy'] = $enemyCharacter ? $enemyCharacter->id : -1;
        $contest = Contest::create($data);
        $contest->characters()->sync([$character->id, $data['enemy']]);
        return redirect() -> route('contests.show', ['contest' => $contest]);
    }
    public function attack(Contest $contest, string $type)
    {
        $this->authorize('update', $contest);
        $hero = $contest->characters->firstWhere('enemy', false);
        $enemy = $contest->characters->firstWhere('enemy', true);
        $damage = $this->calculateDamage($type, $hero, $enemy);
        $newHP = $this->calculateNewHealth($damage, $hero);
        $contest->characters()->updateExistingPivot($hero->id, ['enemy_hp' => $newHP]);
        $contest->characters()->updateExistingPivot($enemy->id, ['enemy_hp' => $newHP]);
        $newHistory = $hero->name . ': ' . $type . ' attack - ' . $damage . ' damage';
        $history = ltrim($contest->history . "\n" . $newHistory, "\n");
        $contest->update(['history' => $history]);
        if ($newHP == 0) {
            $contest->win = true;
            $contest->save();
            return redirect() -> route('contests.show', ['contest' => $contest]);
        }
        $randomNum = rand(0,2);
        $enemyAttack = '';
        switch ($randomNum) {
            case 0:
                $enemyAttack = 'melee';
                break;
            case 1:
                $enemyAttack = 'ranged';
                break;
            case 2:
                $enemyAttack = 'special';
                break;
            default:
                break;
        }
        $damage = $this->calculateDamage($enemyAttack, $enemy, $hero);
        $newHP = $this->calculateNewHealth($damage, $enemy);
        $contest->characters()->updateExistingPivot($hero->id, ['hero_hp' => $newHP]);
        $contest->characters()->updateExistingPivot($enemy->id, ['hero_hp' => $newHP]);
        $newHistory = $enemy->name . ': ' . $enemyAttack . ' attack - ' . $damage . ' damage';
        $history = ltrim($contest->history . "\n" . $newHistory, "\n");
        $contest->update(['history' => $history]);
        if ($newHP == 0) {
            $contest->win = false;
            $contest->save();
        }
        return redirect() -> route('contests.show', ['contest' => $contest]);
    }
    private function calculateNewHealth(float $damage, Character $attacker) : float
    {
        $hp = $attacker->enemy ? $attacker->pivot->hero_hp : $attacker->pivot->enemy_hp;
        if ($hp - $damage > 0) {
            return $hp - $damage;
        } else {
            return 0;
        }
    }
    private function calculateDamage(string $type, Character $attacker, Character $defender) : float
    {
        $dmg = 0;
        switch ($type) {
            case 'melee':
                $dmg = (($attacker->strength * 0.7 + $attacker->accuracy * 0.1 + $attacker->magic * 0.1) - $defender->defence);
                break;
            case 'ranged':
                $dmg = (($attacker->strength * 0.1 + $attacker->accuracy * 0.7 + $attacker->magic * 0.1) - $defender->defence);
                break;
            case 'special':
                $dmg = (($attacker->strength * 0.1 + $attacker->accuracy * 0.1 + $attacker->magic * 0.7) - $defender->defence);
                break;
            default:
                break;
        }
        return $dmg > 0 ? $dmg : 0;
    }
}
