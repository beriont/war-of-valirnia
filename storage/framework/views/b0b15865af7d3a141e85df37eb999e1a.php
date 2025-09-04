<?php $__env->startSection('content'); ?>
    <div class="game-container" style="background-image: url(<?php echo e($def ? asset('storage/img/default.jpg') : asset('storage/' . $place->image)); ?>)">
        <div class="inner-container">
            <h2 class="place-name"><?php echo e($place->name); ?></h2>
            <div class="characters">
                <table class="hero-table <?php echo e($enemyHP == 0 ? 'winner' : ''); ?> <?php echo e($heroHP == 0 ? 'loser' : ''); ?>">
                    <tr>
                        <th>Name</th>
                        <th>Def.</th>
                        <th>Str.</th>
                        <th>Acc.</th>
                        <th>Mag.</th>
                        <th>HP</th>
                    </tr>
                    <tr>
                        <td><?php echo e($hero->name); ?></td>
                        <td><?php echo e($hero->defence); ?></td>
                        <td><?php echo e($hero->strength); ?></td>
                        <td><?php echo e($hero->accuracy); ?></td>
                        <td><?php echo e($hero->magic); ?></td>
                        <td><?php echo e($heroHP); ?></td>
                    </tr>
                </table>
                <p id="versus">VS</p>
                <table class="<?php echo e($enemyHP == 0 ? 'loser' : ''); ?> <?php echo e($heroHP == 0 ? 'winner' : ''); ?>">
                    <tr>
                        <th>Name</th>
                        <th>Def.</th>
                        <th>Str.</th>
                        <th>Acc.</th>
                        <th>Mag.</th>
                        <th>HP</th>
                    </tr>
                    <tr>
                        <td><?php echo e($enemy->name); ?></td>
                        <td><?php echo e($enemy->defence); ?></td>
                        <td><?php echo e($enemy->strength); ?></td>
                        <td><?php echo e($enemy->accuracy); ?></td>
                        <td><?php echo e($enemy->magic); ?></td>
                        <td><?php echo e($enemyHP); ?></td>
                    </tr>
                </table>
            </div>
            <div class="history-container">
                <div class="history">
                    <?php if(count($historyArr) !== 0): ?>
                        <?php for($i = count($historyArr)-1; $i >= 0; $i--): ?>
                            <p class="history-entry"><?php echo e($i + 1); ?>. <?php echo e($historyArr[$i]); ?></p>
                        <?php endfor; ?>
                    <?php else: ?>
                        <p class="history-entry">No history yet</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="gamebuttons game-page">
                <?php if($contest->win !== null): ?>
                    <?php if(auth()->user()->admin && $hero->user_id != auth()->user()->id): ?>
                        <p id="endgame"><?php echo e($contest->win ? 'The user won' : 'The user lost'); ?></p>
                    <?php else: ?>
                        <p id="endgame"><?php echo e($contest->win ? 'You won!' : 'You lost.'); ?></p>
                    <?php endif; ?>
                <?php elseif($nocontinue): ?>
                    <p id="endgame">Cannot continue this match. (Opponent deleted)</p>
                <?php else: ?>
                    <a class="button" href="<?php echo e(route('contests.attack', ['contest' => $contest, 'type' => 'melee'])); ?>">Melee</a>
                    <a class="button" href="<?php echo e(route('contests.attack', ['contest' => $contest, 'type' => 'ranged'])); ?>">Ranged</a>
                    <a class="button" href="<?php echo e(route('contests.attack', ['contest' => $contest, 'type' => 'special'])); ?>">Special</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/contests/show.blade.php ENDPATH**/ ?>