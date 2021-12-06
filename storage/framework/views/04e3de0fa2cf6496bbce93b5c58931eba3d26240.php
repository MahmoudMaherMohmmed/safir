
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-4">
            <a class="tile tile-light-blue" data-stop="500" href="<?php echo e(url('users')); ?>">
                <div class="img img-center">
                    <i class="fa fa-users"></i>
                    <p class="title text-center"><?php echo e($users); ?></p>
                    <p class="title text-center"><?php echo app('translator')->get('messages.users.users'); ?></p>
                </div>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\safir\resources\views/dashboard/index.blade.php ENDPATH**/ ?>