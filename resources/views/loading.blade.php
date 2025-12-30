<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loading | Petrol Station Sales System</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1c92d2, #f2fcfe);
            position: relative;
            overflow: hidden;
        }

        /* Dark overlay for readability */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 0;
        }

        /* Loader container */
        .loader-container {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
        }

        /* Loading text */
        .loader-text {
            font-size: 22px;
            font-weight: 600;
            letter-spacing: 2px;
            margin-bottom: 25px;
            color: #fff;
            text-shadow: 0 2px 8px rgba(0,0,0,0.4);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.05); }
        }

        /* Dots loader */
        .dots {
            display: inline-flex;
            gap: 10px;
        }

        .dots span {
            width: 14px;
            height: 14px;
            background: #22c55e;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        .dots span:nth-child(1) { animation-delay: -0.32s; }
        .dots span:nth-child(2) { animation-delay: -0.16s; }
        .dots span:nth-child(3) { animation-delay: 0s; }
        .dots span:nth-child(4) { animation-delay: 0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }

        /* Optional: smooth fade-in for loader */
        .loader-container {
            opacity: 0;
            animation: fadeIn 0.8s forwards;
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>

    <script>
        // Redirect after 3 seconds
        setTimeout(function () {
            window.location.href = "{{ route('welcome') }}";
        }, 3000);
    </script>
</head>
<body>

    <div class="overlay"></div>

    <div class="loader-container">
        <div class="loader-text">Loading...</div>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

</body>
</html>
