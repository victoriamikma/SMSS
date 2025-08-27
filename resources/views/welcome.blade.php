<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SwiftSolve School System') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-orange: #ff6b35;
            --orange-light: #ff9e1b;
            --orange-dark: #e94e1b;
            --orange-pale: #fff5f0;
            --gray-dark: #2d3748;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }
        
        /* Login Container Styles */
        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--orange-pale) 0%, #e2e8f0 100%);
            padding: 20px;
        }
        
        .login-container h1 {
            color: var(--primary-orange);
            margin-bottom: 2rem;
            font-size: 2.5rem;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        
        .login-form {
            background: white;
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            transition: all 0.3s ease;
        }
        
        .login-form:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .login-form input {
            width: 100%;
            padding: 15px;
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        
        .login-form input:focus {
            outline: none;
            border-color: var(--primary-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
        }
        
        .login-form button {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-orange);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }
        
        .login-form button:hover {
            background-color: var(--orange-dark);
            transform: translateY(-2px);
        }
        
        .login-form p {
            color: #7f8c8d;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .login-form a {
            color: var(--primary-orange);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .login-form a:hover {
            color: var(--orange-dark);
            text-decoration: underline;
        }
        
        /* Animation for inputs */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .login-form input {
            animation: fadeIn 0.5s ease forwards;
        }
        
        .login-form input:nth-child(1) {
            animation-delay: 0.1s;
        }
        
        .login-form input:nth-child(2) {
            animation-delay: 0.2s;
        }
        
        .login-form button {
            animation: fadeIn 0.5s ease 0.3s forwards;
        }
        
        .login-form p {
            animation: fadeIn 0.5s ease 0.4s forwards;
        }
        
        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }
            
            .login-form {
                padding: 1.5rem;
            }
            
            .login-container h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Login Section -->
    <div class="login-container">
        <h1>SwiftSolve Login</h1>
        <form class="login-form" method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required autofocus>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>
                Don't have an account? 
                <a href="{{ route('register') }}">Register here</a>
                @if(Route::has('password.request'))
                    or <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </p>
        </form>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</body>
</html>