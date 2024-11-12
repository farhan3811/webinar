<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f7fafc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
            flex-direction: column;
        }

        .message {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            color: #333;
            animation: fadeIn 1.5s ease-out;
        }

        .sub-message {
            font-size: 1.2rem;
            text-align: center;
            color: #666;
            margin-top: 20px;
            animation: fadeIn 2s ease-out;
        }

        .animation-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 200px;
            height: 200px;
            animation: bounce 1.5s infinite alternate;
        }

        .circle {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color: #f87171;
            animation: bounce 1.5s ease-in-out infinite alternate;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0% {
                transform: translateY(0);
            }
            100% {
                transform: translateY(-50px);
            }
        }
    </style>
</head>
<body>
    <div class="animation-container">
        <div class="circle"></div>
    </div>

    <div class="message">404 - Page Not Found</div>
    <div class="sub-message">Oops! The page you are looking for does not exist.</div>
</body>
</html>
