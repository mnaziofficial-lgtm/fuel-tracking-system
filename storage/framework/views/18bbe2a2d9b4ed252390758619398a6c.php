<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sales tracking</title>
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Body & Background */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #1c92d2, #f2fcfe);
            position: relative;
        }

        /* Dark overlay */
        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.25);
            z-index: 0;
        }

        /* Center container */
        .wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            width: 100%;
        }

        /* Card */
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 30px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .card h1 {
            font-size: 32px;
            color: #222;
            margin-bottom: 10px;
            line-height: 1.2;
        }

        .card p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        /* Buttons */
        .actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-login {
            background: linear-gradient(135deg, #2dda6c, #28b463);
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #28b463, #239954);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-register {
            background: linear-gradient(135deg, #3498db, #2c81c0);
        }

        .btn-register:hover {
            background: linear-gradient(135deg, #2c81c0, #2470a8);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* Responsive */
        @media (max-width: 480px) {
            .card h1 {
                font-size: 26px;
            }

            .card p {
                font-size: 14px;
            }

            .btn {
                padding: 10px 22px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <div class="card">
            <h1>Petrol Station<br>Sales System</h1>
            <p>Secure fuel sales tracking & management</p>

            <div class="actions">
                <a href="<?php echo e(route('login')); ?>" class="btn btn-login">Login</a>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-register">Register</a>
            </div>
        </div>
    </div>

</body>
</html>
<?php /**PATH C:\Users\SHAYO\Desktop\laravel\tracking\resources\views/welcome.blade.php ENDPATH**/ ?>