

<?php $__env->startSection('content'); ?>
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Users</h2>

    <div class="mb-4">
        <a href="<?php echo e(route('admin.users.create')); ?>" class="inline-block px-4 py-2 bg-green-600 text-white rounded">Create User</a>
    </div>

    <?php if(session('status')): ?>
        <div class="mb-4 text-green-600"><?php echo e(session('status')); ?></div>
    <?php endif; ?>

    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead>
            <tr>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Role</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="border px-4 py-2"><?php echo e($user->name); ?></td>
                <td class="border px-4 py-2"><?php echo e($user->email); ?></td>
                <td class="border px-4 py-2"><?php echo e($user->role); ?></td>
                <td class="border px-4 py-2">
                    <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="text-indigo-600 hover:underline mr-2">Edit</a>

                    <?php if(auth()->id() !== $user->id): ?>
                    <form method="POST" action="<?php echo e(route('admin.users.destroy', $user)); ?>" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                    <?php else: ?>
                        <span class="text-gray-400">(you)</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div class="mt-4">
        <?php echo e($users->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/admin/users/index.blade.php ENDPATH**/ ?>