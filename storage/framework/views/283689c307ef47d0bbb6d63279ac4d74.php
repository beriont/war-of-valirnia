<?php $__env->startSection('content'); ?>
    <h2><?php echo e($character->name); ?></h2>
    <h3>Stats:</h3>
    <p class="showpage"><b>Type:</b> <?php echo e($character->enemy ? 'Enemy' : 'Hero'); ?></p>
    <p class="showpage"><b>Defence:</b> <?php echo e($character->defence); ?></p>
    <p class="showpage"><b>Strength:</b> <?php echo e($character->strength); ?></p>
    <p class="showpage"><b>Accuracy:</b> <?php echo e($character->accuracy); ?></p>
    <p class="showpage"><b>Magic:</b> <?php echo e($character->magic); ?></p>
    <div class="gamebuttons">
        <?php if (! ($character->enemy)): ?>
            <a href="<?php echo e(route('contests.create', ['character' => $character])); ?>" class="button">New match</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $character)): ?>
            <a href="<?php echo e(route('characters.edit', ['character' => $character])); ?>" class="button">Edit</a>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $character)): ?>
            <form action="<?php echo e(route('characters.destroy', ['character' => $character])); ?>" method="POST" class="formbutton">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <a href="#" onclick="this.closest('form').submit()" class="button">Delete</a>
            </form>
        <?php endif; ?>
    </div>
    <?php if (! ($character->enemy)): ?>
        <p class="showpage"><b>Matches played:</b></p>
        <ul>
            <?php $__empty_1 = true; $__currentLoopData = $character->contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <li><a href="<?php echo e(route('contests.show', ['contest' => $contest])); ?>" class="redlink"><?php echo e($places[$loop->index]); ?> - <?php echo e($enemies[$loop->index]); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p>No matches yet.</p>
            <?php endif; ?>
        </ul>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/characters/show.blade.php ENDPATH**/ ?>