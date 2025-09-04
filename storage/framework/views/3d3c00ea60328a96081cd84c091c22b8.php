<?php $__env->startSection('content'); ?>
<h2>Create new place</h2>
<form action="<?php echo e(route('places.store')); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>

    Name:<br>
    <input type="text" name="name" value="<?php echo e(old('name', '')); ?>">
    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br>
    Image:<br>
    <input type="file" name="image">
    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <span class="error"><?php echo e($message); ?></span>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <br><br>

    <button class="button" type="submit">Save</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/places/create.blade.php ENDPATH**/ ?>