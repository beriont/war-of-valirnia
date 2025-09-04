<?php $__env->startSection('content'); ?>
    <h2>Places</h2>
    <?php if (! ($places->isEmpty())): ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Picture</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?php $__currentLoopData = $places; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $place): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($place->name); ?></td>
                    <td class="image"><img src="<?php echo e(asset('storage/' . $place->image)); ?>" alt=""></td>
                    <td><a href="<?php echo e(route('places.edit', ['place' => $place])); ?>" class="redlink">Edit</a></td>
                    <td><form action="<?php echo e(route('places.destroy', ['place' => $place])); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <a href="#" onclick="this.closest('form').submit()" class="redlink">Delete</a>
                    </form></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    <?php else: ?>
        <h3>You have no places yet.</h3>
    <?php endif; ?>
    <div class="gamebuttons">
        <a href="<?php echo e(route('places.create')); ?>" class="button">Add place</a>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/places/index.blade.php ENDPATH**/ ?>