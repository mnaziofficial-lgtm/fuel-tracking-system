

<?php $__env->startSection('content'); ?>
<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px; color: #1e293b; font-weight: 700;">Government Cap Prices</h1>
    </div>

    <?php if($pumpRegions->count() > 0): ?>
    <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border: 1px solid #bfdbfe; margin-bottom: 20px;">
        <label for="region-filter" style="display: block; font-weight: 600; color: #1e40af; margin-bottom: 10px;">🔍 Filter by Region (Pump Regions Only)</label>
        <form method="GET" action="<?php echo e(route('admin.govcap.upload')); ?>" style="display: flex; gap: 10px;">
            <select name="region" id="region-filter" style="padding: 10px 15px; border: 1px solid #bfdbfe; border-radius: 4px; font-size: 14px; background: white; cursor: pointer;">
                <option value="all">All Pump Regions</option>
                <?php $__currentLoopData = $pumpRegions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($region); ?>" <?php if($selectedRegion === $region): ?> selected <?php endif; ?>><?php echo e($region); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button type="submit" style="background-color: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600;">Filter</button>
        </form>
    </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            ✓ <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            ✗ <?php echo nl2br(e(session('error'))); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            <ul style="margin: 0; padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

   
       

        <form method="POST" action="<?php echo e(route('admin.govcap.upload.submit')); ?>" enctype="multipart/form-data" style="max-width: 500px;">
            <?php echo csrf_field(); ?>
            <div style="margin-bottom: 15px;">
                <label for="gov_cap_file" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">
                    Select File (Excel or CSV) <span style="color: #dc3545;">*</span>
                </label>
                <input type="file" id="gov_cap_file" name="gov_cap_file" accept=".xlsx,.xls,.csv" 
                       style="display: block; padding: 10px; border: 2px solid #dee2e6; border-radius: 4px; width: 100%; box-sizing: border-box; font-size: 14px;" 
                       required>
                <small style="color: #6c757d; display: block; margin-top: 5px;">Supported formats: .xlsx (Excel), .csv (Comma-separated values)</small>
            </div>
            <button type="submit" style="background-color: #10b981; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600;">
                📤 Upload Prices
            </button>
        </form>
    </div>

    <?php if(!empty($latestPrices)): ?>
    <div>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333; font-size: 18px; font-weight: 600;">Current Cap Prices by Region</h3>
        <div style="display: grid; gap: 15px;">
            <?php $__currentLoopData = $latestPrices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $region => $fuelTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">
                    <h4 style="margin: 0 0 15px 0; color: #1e293b; font-size: 16px; font-weight: 600;"><?php echo e($region); ?></h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                        <?php $__currentLoopData = $fuelTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fuelType => $prices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $latestPrice = $prices->sortByDesc('effective_date')->first();
                            ?>
                            <div style="background: #f8fafc; padding: 12px; border-radius: 4px; border-left: 4px solid #2563eb;">
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 5px;"><?php echo e($fuelType); ?></div>
                                <div style="font-size: 18px; font-weight: 700; color: #1e293b;">TSH<?php echo e(number_format($latestPrice->cap_price, 2)); ?></div>
                                <div style="font-size: 11px; color: #9ca3af; margin-top: 5px;">
                                    Updated: <?php echo e(\Carbon\Carbon::parse($latestPrice->effective_date)->format('M d, Y')); ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/admin/govcap/upload.blade.php ENDPATH**/ ?>