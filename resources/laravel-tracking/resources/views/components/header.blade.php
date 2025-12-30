<div class="header">
    <div class="container">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h1>Tracking System</h1>
            </a>
        </div>
        <nav class="navbar">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.pumps.index') }}">Pumps</a></li>
                <li><a href="{{ route('admin.sales.index') }}">Sales</a></li>
                <li><a href="{{ route('auth.logout') }}">Logout</a></li>
            </ul>
        </nav>
    </div>
</div>

<style>
    .header {
        background-color: #667eea;
        padding: 15px 0;
        color: white;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo h1 {
        margin: 0;
        font-size: 24px;
    }

    .navbar ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 20px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .navbar a:hover {
        color: #f8f9ff;
    }
</style>