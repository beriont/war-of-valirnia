<?php $__env->startSection('content'); ?>
    <h2>Your heroes</h2>
    <?php if (! ($heroes->isEmpty())): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Defence</th>
                <th>Strength</th>
                <th>Accuracy</th>
                <th>Magic</th>
                <th>Details</th>
            </tr>
            <?php $__currentLoopData = $heroes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($character->name); ?></td>
                    <td><?php echo e($character->defence); ?></td>
                    <td><?php echo e($character->strength); ?></td>
                    <td><?php echo e($character->accuracy); ?></td>
                    <td><?php echo e($character->magic); ?></td>
                    <td><a href="<?php echo e(route('characters.show', ['character' => $character])); ?>" class="redlink">Details</a></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php else: ?>
        <h3>You have no heroes yet.</h3>
    <?php endif; ?>
    <?php if(auth()->user()->admin): ?>
        <h2>Enemy characters</h2>
        <?php if (! ($enemies->isEmpty())): ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Defence</th>
                    <th>Strength</th>
                    <th>Accuracy</th>
                    <th>Magic</th>
                    <th>Details</th>
                </tr>
                <?php $__currentLoopData = $enemies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $character): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($character->name); ?></td>
                        <td><?php echo e($character->defence); ?></td>
                        <td><?php echo e($character->strength); ?></td>
                        <td><?php echo e($character->accuracy); ?></td>
                        <td><?php echo e($character->magic); ?></td>
                        <td><a href="<?php echo e(route('characters.show', ['character' => $character])); ?>" class="redlink">Details</a></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </table>
        <?php else: ?>
            <h3>No enemy characters found.</h3>
        <?php endif; ?>
    <?php endif; ?>
    <div class="gamebuttons">
        <a href="<?php echo e(route('characters.create')); ?>" class="button">Add character</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/characters/index.blade.php ENDPATH**/ ?>