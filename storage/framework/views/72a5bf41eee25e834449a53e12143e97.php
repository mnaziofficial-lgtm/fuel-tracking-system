<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
/* SIDEBAR BASE */
.sidebar {
    width: 240px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #0f172a; /* dark slate */
    padding: 20px 15px;
    color: #e5e7eb;
    display: flex;
    flex-direction: column;
}

/* HEADER */
.sidebar h2 {
    font-size: 17px;
    text-align: center;
    margin-bottom: 30px;
    font-weight: 700;
    color: #ffffff;
}

/* LINKS */
.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    margin-bottom: 8px;
    border-radius: 8px;
    color: #cbd5f5;
    font-weight: 600;
    text-decoration: none;
    transition: 0.25s;
}

/* ICON */
.sidebar a i {
    font-size: 16px;
    width: 22px;
    text-align: center;
}

/* HOVER & ACTIVE */
.sidebar a:hover {
    background: #1e293b;
    color: #ffffff;
}

.sidebar a.active {
    background: #1e40af;
    color: #ffffff;
}

/* USER BOX */
.user-box {
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid #1e293b;
}

/* LOGOUT BUTTON */
.logout-btn {
    width: 100%;
    background: none;
    border: none;
    color: #fca5a5;
    font-weight: 600;
    cursor: pointer;
    padding: 12px 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-radius: 8px;
    transition: 0.25s;
}

.logout-btn:hover {
    background: #7f1d1d;
    color: #ffffff;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="sidebar">
    <h2><?php echo e(Auth::user()->name); ?></h2>

    <a href="<?php echo e(route('dashboard')); ?>" class="<?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
        <i class="fa-solid fa-house"></i>
        <span>Dashboard</span>
    </a>

    <?php if(Auth::user()->isAdmin()): ?>
        <a href="<?php echo e(route('admin.users.index')); ?>">
            <i class="fa-solid fa-users"></i>
            <span>Attendants</span>
        </a>

        <a href="<?php echo e(route('admin.pumps.index')); ?>">
            <i class="fa-solid fa-gas-pump"></i>
            <span>Pumps</span>
        </a>
        <a href="<?php echo e(route('admin.govcap.upload')); ?>">
                <i class="fa-solid fa-file-excel"></i>
                <span>CAP prices</span>
            </a>

        <a href="<?php echo e(route('shifts.index')); ?>">
            <i class="fa-solid fa-clock"></i>
            <span>Shifts</span>
        </a>

        <a href="<?php echo e(route('sales.index')); ?>">
            <i class="fa-solid fa-chart-line"></i>
            <span>All Sales</span>
        </a>

        <a href="<?php echo e(route('sales.download')); ?>">
            <i class="fa-solid fa-download"></i>
            <span>Download Sales</span>
        </a>

    
    <?php endif; ?>

    <?php if(Auth::user()->isAttendant()): ?>
        <a href="<?php echo e(route('sales.create')); ?>"
           class="<?php echo e(request()->routeIs('sales.create') ? 'active' : ''); ?>">
            <i class="fa-solid fa-receipt"></i>
            <span>Record Sale</span>
        </a>

        <a href="<?php echo e(route('shifts.index')); ?>">
            <i class="fa-solid fa-clock-rotate-left"></i>
            <span>My Shifts</span>
        </a>
    <?php endif; ?>

    <div class="user-box">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

</body>
</html>
<?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>