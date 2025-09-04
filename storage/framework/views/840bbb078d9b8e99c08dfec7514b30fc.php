<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>War of Valirnia - Combat Game</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/main.js', 'resources/css/main.css']); ?>
</head>
<body>
    <header>
        <h1><a href="<?php echo e(route('home')); ?>">War of Valirnia</a></h1>
        <div id="accman">
            <?php if(auth()->guard()->check()): ?>
                <p class="usertop"><?php echo e(Auth::user() -> name); ?> 👤</p>
                <a href="<?php echo e(route('characters.index')); ?>" class="button">Characters</a>
                <?php if(Auth::user()->admin): ?>
                    <a href="<?php echo e(route('places.index')); ?>" class="button">Places</a>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="formbutton">
                    <?php echo csrf_field(); ?>
                    <a class="button" href="#" onclick="this.closest('form').submit()">Logout</a>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="button">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="button">Register</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer>
        <p>War of Valirnia | BERIONT, ALL RIGHTS RESERVED 2024</p>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\bence\Documents\Egyetem\2024tavasz\szwebprog\laravel-beadando\beadando_QDMPVQ\resources\views/layouts/main.blade.php ENDPATH**/ ?>