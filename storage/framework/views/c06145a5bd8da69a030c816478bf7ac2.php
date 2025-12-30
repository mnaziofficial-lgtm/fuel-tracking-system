

<?php $__env->startSection('content'); ?>
<style>
.page-wrapper {
    padding: 30px;
    background: #f1f5f9;
    min-height: 100vh;
}

.list-card {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 15px 40px rgba(0,0,0,.08);
}

.list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.list-header h2 {
    font-size: 22px;
    font-weight: 700;
}

.btn-create {
    background: #16a34a;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #0f172a;
    color: #fff;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.action-edit {
    color: #2563eb;
    font-weight: 600;
    margin-right: 10px;
}

.action-delete {
    color: #dc2626;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
}
</style>

<div class="page-wrapper">
    <div class="list-card">
        <div class="list-header">
            <h2>Pumps</h2>
            <a href="<?php echo e(route('admin.pumps.create')); ?>" class="btn-create">+ Create Pump</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Fuel Type</th>
                    <th>Price/L</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $pumps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pump): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($pump->name); ?> <span style="color:#64748b">(<?php echo e($pump->code); ?>)</span></td>
                    <td><?php echo e($pump->region ?? 'N/A'); ?></td>
                    <td><?php echo e($pump->fuel_type); ?></td>
                    <td>TSH <?php echo e(number_format($pump->price_per_litre, 2)); ?></td>
                    <td><?php echo e(number_format($pump->stock, 0)); ?>L</td>
                    <td>
                        <a href="<?php echo e(route('admin.pumps.edit', $pump)); ?>" class="action-edit">Edit</a>
                        <form method="POST" action="<?php echo e(route('admin.pumps.destroy', $pump)); ?>" style="display:inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button onclick="return confirm('Delete this pump?')" class="action-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div style="margin-top:15px">
            <?php echo e($pumps->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/admin/pumps/index.blade.php ENDPATH**/ ?>