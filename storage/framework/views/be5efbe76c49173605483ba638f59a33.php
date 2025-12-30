

<?php $__env->startSection('content'); ?>
<style>
:root {
    --primary: #0f172a;
    --secondary: #1e293b;
    --accent: #2563eb;
    --success: #10b981;
    --warning: #f59e0b;
    --bg: #f1f5f9;
    --card-bg: #ffffff;
    --muted: #64748b;
    --border: #e5e7eb;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 20px;
    color: var(--secondary);
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* ================= HEADER ================= */
.header-content h1 {
    font-size: 32px;
    color: var(--primary);
    font-weight: 800;
}

.header-content p {
    color: var(--muted);
    font-size: 14px;
}

/* ================= BUTTONS ================= */
.btn {
    padding: 10px 20px;
    font-size: 13px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.25s;
    border: none;
}

.btn-primary {
    background: var(--accent);
    color: #fff;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
}

.btn-secondary {
    background: #fff;
    color: var(--accent);
    border: 2px solid var(--accent);
}

/* ================= STAT CARDS ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: var(--card-bg);
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    transition: .3s;
    border-left: 6px solid var(--accent);
}

.stat-card:hover {
    transform: translateY(-6px);
}

.stat-card.litres { border-left-color: var(--success); }
.stat-card.fuels  { border-left-color: var(--warning); }

.stat-label {
    font-size: 12px;
    text-transform: uppercase;
    color: var(--muted);
    letter-spacing: .5px;
}

.stat-value {
    font-size: 30px;
    font-weight: 800;
    color: var(--primary);
}

/* ================= CARDS ================= */
.card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    margin-bottom: 20px;
}

.card-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 20px;
    position: relative;
    padding-left: 12px;
}

.card-title::before {
    content: "";
    position: absolute;
    left: 0;
    top: 2px;
    width: 4px;
    height: 20px;
    background: var(--accent);
    border-radius: 4px;
}

/* ================= INPUTS ================= */
input[type="date"], input[type="file"] {
    padding: 8px 12px;
    border-radius: 8px;
    border: 2px solid var(--border);
    font-size: 13px;
}

input[type="date"]:focus, input[type="file"]:focus {
    outline: none;
    border-color: var(--accent);
}

/* ================= SMALL BUTTONS ================= */
.btn-small {
    padding: 8px 14px;
    border-radius: 8px;
    border: 2px solid var(--border);
    background: #fff;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.btn-small.apply {
    background: var(--accent);
    color: #fff;
    border: none;
}

/* ================= FUEL LIST ================= */
.fuel-item {
    display: flex;
    justify-content: space-between;
    padding: 14px;
    border-radius: 10px;
    background: #f8fafc;
    border-left: 4px solid var(--accent);
    transition: .25s;
}

.fuel-item:hover {
    background: #eef2ff;
    transform: translateX(6px);
}

.fuel-name {
    font-weight: 600;
}

.fuel-price {
    font-size: 12px;
    color: var(--muted);
}

.fuel-stock {
    font-weight: 800;
    color: var(--success);
}

/* ================= TABLE ================= */
.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.table thead {
    background: var(--primary);
    color: #fff;
}

.table thead th {
    padding: 14px;
}

.table tbody tr {
    border-bottom: 1px solid var(--border);
}

.table tbody tr:hover {
    background: #f1f5ff;
}

.table tbody td {
    padding: 12px;
}

/* ================= PAGINATION ================= */
.pagination {
    display: flex;
    justify-content: space-between;
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px solid var(--border);
}

.pagination-buttons button {
    padding: 8px 14px;
    border-radius: 8px;
    border: 2px solid var(--border);
    background: #fff;
    font-weight: 600;
}

.pagination-buttons button:hover {
    border-color: var(--accent);
    color: var(--accent);
}

/* ================= NO DATA ================= */
.no-data {
    text-align: center;
    padding: 30px;
    color: var(--muted);
}
</style>

<div class="dashboard-container">
    <div class="header-section">
        <div class="header-content">
            <h1>Welcome</h1>
            <p>Overview of sales, fuel stock, recent activity & government cap</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card sales">
            <div class="stat-label">Total Sales</div>
            <div class="stat-value"><?php echo e(number_format($totalSales,2)); ?></div>
        </div>

        <div class="stat-card litres">
            <div class="stat-label">Total Litres</div>
            <div class="stat-value"><?php echo e($totalLitres); ?> L</div>
        </div>

        <div class="stat-card fuels">
            <div class="stat-label">Total Pumps</div>
            <div class="stat-value"><?php echo e($pumps->count()); ?></div>
        </div>
    </div>

    <!-- ================= FUEL STOCK (COMPACT) ================= -->
    <div class="card" style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 class="card-title" style="margin: 0;">Pump Stock & Pricing by Region</h3>
            <button id="toggleAllPumps" onclick="toggleAllPumps()" style="background: #2563eb; color: white; padding: 10px 18px; border-radius: 8px; font-weight: 600; border: none; text-decoration: none; font-size: 13px; transition: 0.3s; cursor: pointer;">
                📋 Show All Pumps
            </button>
        </div>
        
        <!-- Initial 3 Pumps -->
        <div id="initialPumps">
            <p style="color: #64748b; font-size: 12px; margin-bottom: 15px;"></p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                <?php $__empty_1 = true; $__currentLoopData = $pumps->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pump): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $capPrice = $pump->cap_price ?? null;
                        $isAboveCap = $capPrice && $pump->price_per_litre > $capPrice;
                        $isLowStock = !is_null($pump->low_stock_threshold) && $pump->stock <= $pump->low_stock_threshold;
                    ?>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; border-left: 6px solid <?php echo e($isLowStock ? '#ef4444' : ($isAboveCap ? '#f87171' : '#2563eb')); ?>;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 15px;"><?php echo e($pump->name); ?></div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">📍 <?php echo e($pump->region ?? 'No Region'); ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 13px; color: #64748b; background: #e2e8f0; padding: 4px 10px; border-radius: 4px; font-weight: 600;"><?php echo e($pump->fuel_type); ?></div>
                            </div>
                        </div>
                        <div style="background: #ffffff; padding: 12px; border-radius: 6px; margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-size: 12px; color: #64748b;">Current Stock:</span>
                                <span style="font-weight: 700; color: <?php echo e($isLowStock ? '#ef4444' : '#059669'); ?>; font-size: 16px;"><?php echo e(number_format($pump->stock, 0)); ?> L</span>
                            </div>
                            <?php if($pump->low_stock_threshold): ?>
                                <div style="font-size: 11px; color: #64748b;">
                                    Threshold: <?php echo e($pump->low_stock_threshold); ?> L
                                    <?php if($isLowStock): ?>
                                        <span style="color: rgb(68, 188, 239); font-weight: 600;"> ⚠️ LOW</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div style="border-top: 1px solid #e5e7eb; padding-top: 10px;">
                            <div style="margin-bottom: 8px;">
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 3px;">Current Price:</div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 16px;">TSH <?php echo e(number_format($pump->price_per_litre, 2)); ?>/L</div>
                            </div>
                            <?php if($capPrice): ?>
                                <div style="background: <?php echo e($isAboveCap ? '#dbeafe' : '#dbeafe'); ?>; padding: 8px 10px; border-radius: 4px; margin-top: 8px;">
                                    <div style="font-size: 11px; color: <?php echo e($isAboveCap ? '#0c4a6e' : '#0c4a6e'); ?>; margin-bottom: 2px;">Cap Price: TSH <?php echo e(number_format($capPrice, 2)); ?>/L</div>
                                    <div style="font-size: 12px; font-weight: 600; color: #059669;">
                                        <?php if($isAboveCap): ?>
                                            ✅ ABOVE CAP (<?php echo e(number_format($pump->price_per_litre - $capPrice, 2)); ?> over)
                                        <?php else: ?>
                                            ✅ WITHIN CAP (<?php echo e(number_format($capPrice - $pump->price_per_litre, 2)); ?> below)
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="font-size: 12px; color: #9ca3af; padding: 8px 10px; background: #f3f4f6; border-radius: 4px; margin-top: 8px;"><em>ℹ️ No cap price data available</em></div>
                            <?php endif; ?>
                        </div>
                        <?php if($pump->code): ?>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e5e7eb; font-size: 11px; color: #9ca3af;">Code: <strong><?php echo e($pump->code); ?></strong></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color: #6b7280; grid-column: 1/-1;">No pumps in the system</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- All Pumps (Hidden by default) -->
        <div id="allPumpsSection" style="display: none;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                <p style="color: #64748b; font-size: 12px; margin: 0;">Showing all <?php echo e($pumps->count()); ?> pumps</p>
                <button onclick="toggleAllPumps()" style="background: #6b7280; color: white; padding: 8px 15px; border-radius: 8px; font-weight: 600; border: none; font-size: 12px; cursor: pointer;">
                    ✕ Hide
                </button>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 15px;">
                <?php $__empty_1 = true; $__currentLoopData = $pumps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pump): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $capPrice = $pump->cap_price ?? null;
                        $isAboveCap = $capPrice && $pump->price_per_litre > $capPrice;
                        $isLowStock = !is_null($pump->low_stock_threshold) && $pump->stock <= $pump->low_stock_threshold;
                    ?>
                    <div style="background: #f8fafc; padding: 16px; border-radius: 8px; border-left: 6px solid <?php echo e($isLowStock ? '#ef4444' : ($isAboveCap ? '#f87171' : '#2563eb')); ?>;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 15px;"><?php echo e($pump->name); ?></div>
                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">📍 <?php echo e($pump->region ?? 'No Region'); ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 13px; color: #64748b; background: #e2e8f0; padding: 4px 10px; border-radius: 4px; font-weight: 600;"><?php echo e($pump->fuel_type); ?></div>
                            </div>
                        </div>
                        <div style="background: #ffffff; padding: 12px; border-radius: 6px; margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <span style="font-size: 12px; color: #64748b;">Current Stock:</span>
                                <span style="font-weight: 700; color: <?php echo e($isLowStock ? '#ef4444' : '#059669'); ?>; font-size: 16px;"><?php echo e(number_format($pump->stock, 0)); ?> L</span>
                            </div>
                            <?php if($pump->low_stock_threshold): ?>
                                <div style="font-size: 11px; color: #64748b;">
                                    Threshold: <?php echo e($pump->low_stock_threshold); ?> L
                                    <?php if($isLowStock): ?>
                                        <span style="color: #ef4444; font-weight: 600;"> ⚠️ LOW</span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div style="border-top: 1px solid #e5e7eb; padding-top: 10px;">
                            <div style="margin-bottom: 8px;">
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 3px;">Current Price:</div>
                                <div style="font-weight: 700; color: #1e293b; font-size: 16px;">TSH <?php echo e(number_format($pump->price_per_litre, 2)); ?>/L</div>
                            </div>
                            <?php if($capPrice): ?>
                                <div style="background: <?php echo e($isAboveCap ? '#dbeafe' : '#dbeafe'); ?>; padding: 8px 10px; border-radius: 4px; margin-top: 8px;">
                                    <div style="font-size: 11px; color: <?php echo e($isAboveCap ? '#0c4a6e' : '#0c4a6e'); ?>; margin-bottom: 2px;">Cap Price: TSH <?php echo e(number_format($capPrice, 2)); ?>/L</div>
                                    <div style="font-size: 12px; font-weight: 600; color: #059669;">
                                        <?php if($isAboveCap): ?>
                                            ✅ ABOVE CAP (<?php echo e(number_format($pump->price_per_litre - $capPrice, 2)); ?> over)
                                        <?php else: ?>
                                            ✅ WITHIN CAP (<?php echo e(number_format($capPrice - $pump->price_per_litre, 2)); ?> below)
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div style="font-size: 12px; color: #9ca3af; padding: 8px 10px; background: #f3f4f6; border-radius: 4px; margin-top: 8px;"><em>ℹ️ No cap price data available</em></div>
                            <?php endif; ?>
                        </div>
                        <?php if($pump->code): ?>
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #e5e7eb; font-size: 11px; color: #9ca3af;">Code: <strong><?php echo e($pump->code); ?></strong></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color: #6b7280; grid-column: 1/-1;">No pumps in the system</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function toggleAllPumps() {
            const initialPumps = document.getElementById('initialPumps');
            const allPumpsSection = document.getElementById('allPumpsSection');
            const toggleBtn = document.getElementById('toggleAllPumps');

            if (allPumpsSection.style.display === 'none') {
                initialPumps.style.display = 'none';
                allPumpsSection.style.display = 'block';
                toggleBtn.textContent = '📋 Show Less';
            } else {
                initialPumps.style.display = 'block';
                allPumpsSection.style.display = 'none';
                toggleBtn.textContent = '📋 Show All Pumps';
            }
        }
    </script>

    <!-- ================= LOW STOCK ALERTS ================= -->
    <?php if(!empty($lowStockPumps) && $lowStockPumps->count()): ?>
    <div class="card mb-4">
        <h3 class="card-title">Low Stock Alerts</h3>
        <div class="fuel-list">
            <?php $__currentLoopData = $lowStockPumps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $capPrice = $lp->cap_price ?? null;
                    $isAboveCap = $capPrice && $lp->price_per_litre > $capPrice;
                ?>
                <div class="fuel-item" style="border-left-color: <?php echo e($isAboveCap ? '#f87171' : '#2563eb'); ?>;">
                    <div class="fuel-info">
                        <div class="fuel-name"><?php echo e($lp->name); ?> <?php echo e($lp->code ? '('.$lp->code.')' : ''); ?></div>
                        <div class="fuel-price">
                            <?php echo e(number_format($lp->price_per_litre,2)); ?> / L
                            <?php if($capPrice): ?>
                                <span style="font-size:11px; color: <?php echo e($isAboveCap ? '#b91c1c' : '#64748b'); ?>">
                                    (Cap: <?php echo e(number_format($capPrice,2)); ?>)
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="fuel-stock"><?php echo e($lp->stock); ?> L</div>
                    <div class="ml-3">
                        <a href="<?php echo e(route('admin.pumps.edit', $lp)); ?>" class="text-indigo-600 hover:underline">Manage</a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= RECENT SALES ================= -->
    <h3 class="card-title">Recent Sales</h3>
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Pump</th>
                    <th>Fuel</th>
                    <th>Price/L(TSH)</th>
                    <th>Litres</th>
                    <th>Amount(TSH)</th>
                    <th>Attendant</th>
                </tr>
            </thead>
            <tbody id="recentSalesBody">
                <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($sale->created_at->format('Y-m-d H:i')); ?></td>
                    <td><?php echo e(optional($sale->pump)->name); ?> <?php echo e(optional($sale->pump)->code ? '('.optional($sale->pump)->code.')' : ''); ?></td>
                    <td><?php echo e(optional($sale->pump)->fuel_type); ?></td>
                    <td><?php echo e(number_format(optional($sale->pump)->price_per_litre ?? 0, 2)); ?></td>
                    <td><?php echo e($sale->litres_sold); ?></td>
                    <td><?php echo e(number_format($sale->amount,2)); ?></td>
                    <td><?php echo e(optional($sale->user)->name); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="no-data">No recent sales</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <div class="pagination-info" id="recentSalesInfo">&nbsp;</div>
        <div class="pagination-buttons">
            <button id="recentPrev">← Previous</button>
            <button id="recentNext">Next →</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
const ctx = document.getElementById('adminSalesChart').getContext('2d');
const adminSalesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [
            { label: 'Sales Amount (TSH)', data: <?php echo json_encode($chartAmounts); ?>, yAxisID: 'y-amount', borderColor: '#3b82f6', backgroundColor: '#3b82f6', fill: false, tension: 0.15, pointRadius: 2 },
            { label: 'Litres Sold (L)', data: <?php echo json_encode($chartLitres); ?>, yAxisID: 'y-litres', borderColor: '#10b981', backgroundColor: '#10b981', fill: false, tension: 0.15, pointRadius: 2 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, scales: { 'y-amount': { type: 'linear', position: 'left', min: 0, title: { display: true, text: 'TSH' } }, 'y-litres': { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Litres' } } }, plugins: { legend: { position: 'top' } } }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>