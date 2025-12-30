

<?php $__env->startSection('content'); ?>
<style>
:root {
    --primary: #0f172a;
    --accent: #2563eb;
    --success: #10b981;
    --bg: #f1f5f9;
    --card-bg: #ffffff;
    --border: #e5e7eb;
    --muted: #64748b;
}

.page-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
}

.download-card {
    background: var(--card-bg);
    border-radius: 14px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
}

.page-title {
    font-size: 28px;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 10px;
}

.page-subtitle {
    color: var(--muted);
    margin-bottom: 30px;
    font-size: 14px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 10px;
    font-size: 14px;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 14px;
    transition: 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.date-range-group {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.date-range-group.hidden {
    display: none;
}

.btn-download {
    width: 100%;
    padding: 14px;
    background: var(--success);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

.btn-download:hover {
    background: #059669;
    transform: translateY(-2px);
}

.btn-back {
    display: inline-block;
    color: var(--accent);
    text-decoration: none;
    font-weight: 600;
    margin-bottom: 20px;
    font-size: 14px;
}

.btn-back:hover {
    text-decoration: underline;
}

.info-box {
    background: #f0f9ff;
    border-left: 4px solid var(--accent);
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 13px;
    color: #0c4a6e;
}

.info-box strong {
    display: block;
    margin-bottom: 8px;
}
</style>

<div class="page-container">
    <a href="<?php echo e(route('sales.index')); ?>" class="btn-back">← Back to Sales</a>

    <div class="download-card">
        <h1 class="page-title">📥 Download Sales Report</h1>
        <p class="page-subtitle">Export sales data in CSV format</p>

        <div class="info-box">
            <strong>ℹ️ Export Details</strong>
            The CSV file will include: Date, Pump, Region, Fuel Type, Price/L, Litres Sold, Amount, and Attendant
        </div>

        <form method="GET" action="<?php echo e(route('sales.download')); ?>">
            <div class="form-group">
                <label for="timeframe" class="form-label">Select Period</label>
                <select name="timeframe" id="timeframe" class="form-control">
                    <option value="all">All Records</option>
                    <option value="today">Today Only</option>
                    <option value="week">Last 7 Days</option>
                    <option value="month">This Month</option>
                    <option value="custom">Custom Date Range</option>
                </select>
            </div>

            <div class="form-group date-range-group hidden" id="custom-dates">
                <div>
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
                <div>
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn-download">
                📊 Download CSV
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('timeframe').addEventListener('change', function() {
    const customDates = document.getElementById('custom-dates');
    if (this.value === 'custom') {
        customDates.classList.remove('hidden');
    } else {
        customDates.classList.add('hidden');
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/sales/download.blade.php ENDPATH**/ ?>