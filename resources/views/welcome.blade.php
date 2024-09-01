<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .welcome-section {
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
            text-align: center;
        }
        .welcome-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 5px;
            border-radius: 10px;
        }
        .welcome-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        .welcome-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .welcome-buttons a {
            margin: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
        }
        .loginbtn{
            background-color:#1E2738;
            color:white;
            border: #1E2738 solid 1px;
        }
    </style>
</head>
    <x-guest-layout>
        <!-- Session Status -->
        <div class="welcome-section">
            <div class="welcome-content">
                <h1>Welcome to ChatApp</h1>
                <p>Your secure and seamless communication platform.</p>
                <div class="welcome-buttons">
                    <a href="{{ route('login') }}" class="btn btn-light loginbtn">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary">Register</a>
                </div>
            </div>
        </div>
    </x-guest-layout>
</html>




