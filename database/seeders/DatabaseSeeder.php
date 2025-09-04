<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Contest;
use App\Models\Place;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = collect();
        $users -> add(User::create([
            'email' => 'admin@gmail.com',
            'name' => 'admin',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'admin' => true
        ]));
        for ($i = 2; $i <= 10; $i++){
            $user = User::create([
                'email' => 'user'.$i.'@gmail.com',
                'name' => fake() -> name(),
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'admin' => rand(1,10) < 3
            ]);
            $users -> add($user);
        }
        $admins = User::where('admin', true);

        $characters = collect();
        for ($i = 1; $i <= 15; $i++){
            $stats = $this->generateStats();
            if (rand(1, 10) < 7) {
                $character = Character::create([
                    'name' => ucfirst(fake() -> unique() -> word()),
                    'enemy' => false,
                    'defence' => $stats[0],
                    'strength' => $stats[1],
                    'accuracy' => $stats[2],
                    'magic' => $stats[3],
                    'user_id' => $users -> random() -> id
                ]);
            } else {
                $character = Character::create([
                    'name' => ucfirst(fake() -> unique() -> word()),
                    'enemy' => true,
                    'defence' => $stats[0],
                    'strength' => $stats[1],
                    'accuracy' => $stats[2],
                    'magic' => $stats[3],
                    'user_id' => $admins->inRandomOrder()->first()->id
                ]);
            }
            $characters -> add($character);
        }
        if ($characters->where('enemy', true)->isEmpty()) {
            $stats = $this->generateStats();
            $characters -> add(Character::create([
                'name' => ucfirst(fake() -> unique() -> word()),
                'enemy' => true,
                'defence' => $stats[0],
                'strength' => $stats[1],
                'accuracy' => $stats[2],
                'magic' => $stats[3],
                'user_id' => $admins->inRandomOrder()->first()->id
            ]));
        }
        $heroes = Character::where('enemy', false);
        $enemies = Character::where('enemy', true);

        $places = collect();
        $places->add(Place::create([
            'name' => 'Square of Champions',
            'image' => 'img/1.jpg'
        ]));
        $places->add(Place::create([
            'name' => 'Rocky Temple',
            'image' => 'img/2.jpg'
        ]));
        $places->add(Place::create([
            'name' => 'Shadow Field',
            'image' => 'img/3.jpg'
        ]));


        for ($i = 1; $i <= 10; $i++) {
            $hero = $heroes->inRandomOrder()->first();
            $enemy = $enemies->inRandomOrder()->first();
            $charids = [$hero->id, $enemy->id];
            $won = rand(0, 2);
            switch ($won) {
                case 0:
                    $contest = Contest::create([
                        'user_id' => $hero->user_id,
                        'place_id' => $places -> random() -> id,
                        'win' => true,
                        'history' => $this->generateHistory(0, $hero->name, $enemy->name)
                    ]);
                    $contest->characters()->attach($charids, [
                        'hero_hp' => rand(1,20),
                        'enemy_hp' => 0
                    ]);
                    break;
                case 1:
                    $contest = Contest::create([
                        'user_id' => $hero->user_id,
                        'place_id' => $places -> random() -> id,
                        'win' => false,
                        'history' => $this->generateHistory(1, $hero->name, $enemy->name)
                    ]);
                    $contest->characters()->attach($charids, [
                        'hero_hp' => 0,
                        'enemy_hp' => rand(1,20)
                    ]);
                    break;
                case 2:
                    $contest = Contest::create([
                        'user_id' => $hero->user_id,
                        'place_id' => $places -> random() -> id,
                        'win' => null,
                        'history' => $this->generateHistory(2, $hero->name, $enemy->name)
                    ]);
                    $contest->characters()->attach($charids, [
                        'hero_hp' => rand(1,20),
                        'enemy_hp' => rand(1,20)
                    ]);
                    break;
                default:
                    break;
            }
        }
    }
    private function generateStats() : array
    {
        do {
            $stats = [rand(0,3), rand(0,20), rand(0,20), rand(0,20)];
            $sum = 0;
            for ($j = 0; $j < 4; $j++) {
                $sum += $stats[$j];
            }
        } while ($sum > 20);
        return $stats;
    }
    private function generateHistory($ofCase, $heroName, $enemyName) : string
    {
        $history = '';
        $number = rand(1, 5);
        if ($ofCase === 0 && $number % 2 !== 1) $number++;
        if ($ofCase !== 0 && $number % 2 !== 0) $number++;
        for ($j = 1; $j <= $number; $j++) {
            $attackType = rand(0, 2);
            $dmg = rand(1, 5);
            switch ($attackType) {
                case 0:
                    if ($j % 2 == 1) {
                        $history .= "{$heroName}: melee attack - {$dmg} damage\n";
                    } else {
                        $history .= "{$enemyName}: melee attack - {$dmg} damage\n";
                    }
                    break;
                case 1:
                    if ($j % 2 == 1) {
                        $history .= "{$heroName}: ranged attack - {$dmg} damage\n";
                    } else {
                        $history .= "{$enemyName}: ranged attack - {$dmg} damage\n";
                    }
                    break;
                case 2:
                    if ($j % 2 == 1) {
                        $history .= "{$heroName}: special attack - {$dmg} damage\n";
                    } else {
                        $history .= "{$enemyName}: special attack - {$dmg} damage\n";
                    }
                    break;
                default:
                    break;
            }
        }
        $history = rtrim($history, "\n");
        return $history;
    }
}
