<div class="footer">
    <div class="footer-content">
        <p>&copy; {{ date('Y') }} Laravel Tracking. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.pumps.index') }}">Pumps</a></li>
            <li><a href="{{ route('admin.sales.index') }}">Sales</a></li>
            <li><a href="{{ route('auth.login') }}">Login</a></li>
            <li><a href="{{ route('auth.register') }}">Register</a></li>
        </ul>
    </div>
</div>

<style>
.footer {
    background-color: #2c3e50;
    color: white;
    padding: 20px 0;
    text-align: center;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
}

.footer-links li {
    display: inline;
    margin: 0 15px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-links a:hover {
    color: #667eea;
}
</style>