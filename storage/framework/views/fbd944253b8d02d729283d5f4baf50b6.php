

<?php $__env->startSection('content'); ?>
<style>
.page-wrapper {
    background: #f1f5f9;
    min-height: 100vh;
    padding: 30px;
}

.form-card {
    max-width: 520px;
    margin: auto;
    background: #ffffff;
    padding: 30px;
    border-radius: 14px;
    box-shadow: 0 15px 40px rgba(0,0,0,.08);
}

.form-title {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #0f172a;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
}

.form-group input {
    width: 100%;
    margin-top: 6px;
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    font-size: 14px;
}

.form-group input:focus {
    outline: none;
    border-color: #2563eb;
}

.form-hint {
    font-size: 12px;
    color: #64748b;
    margin-top: 4px;
}

.error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 4px;
}

.form-actions {
    display: flex;
    gap: 10px;
    margin-top: 25px;
}

.btn-primary {
    background: #16a34a;
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
}

.btn-secondary {
    padding: 10px 18px;
    border-radius: 8px;
    border: 2px solid #e5e7eb;
    font-weight: 600;
    text-decoration: none;
    color: #0f172a;
}
</style>

<div class="page-wrapper">
    <div class="form-card">
        <h2 class="form-title">Create Pump</h2>

        <form method="POST" action="<?php echo e(route('admin.pumps.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Region</label>
                <input type="text" name="region" value="<?php echo e(old('region')); ?>" required placeholder="e.g., Lagos, Abuja">
                <div class="form-hint">Must match a region in the uploaded government cap prices</div>
                <?php $__errorArgs = ['region'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Fuel Type</label>
                <input type="text" name="fuel_type" value="<?php echo e(old('fuel_type')); ?>" required>
                <div class="form-hint">e.g. PETROL, DIESEL</div>
                <?php $__errorArgs = ['fuel_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Price per Litre</label>
                <input type="number" step="0.01" min="0" name="price_per_litre" value="<?php echo e(old('price_per_litre')); ?>" required>
                <?php $__errorArgs = ['price_per_litre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Stock Litres</label>
                <input type="number" step="0.01" min="0" name="stock" value="<?php echo e(old('stock')); ?>" required>
                <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Low Stock Threshold</label>
                <input type="number" step="0.01" min="0" name="low_stock_threshold" value="<?php echo e(old('low_stock_threshold')); ?>">
            </div>

            <div class="form-group">
                <label>Code (optional)</label>
                <input type="text" name="code" value="<?php echo e(old('code')); ?>">
            </div>

            <div class="form-actions">
                <button class="btn-primary">Create Pump</button>
                <a href="<?php echo e(route('admin.pumps.index')); ?>" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/admin/pumps/create.blade.php ENDPATH**/ ?>