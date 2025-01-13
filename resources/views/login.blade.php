<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #00bcd4;
        }

        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #333;
            border-radius: 4px;
            background-color: #2c2c2c;
            color: #ffffff;
        }

        .login-container button {
            margin-top: 1em;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #00bcd4;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0097a7;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h1 style="color: #ffffff;">Welcome to Gym Instructor</h1>
        <h1>Login</h1>
        <form action="/login" method="POST">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            @if ($errors->has('email'))
            <div style="color: red;">{{ $errors->first('email') }}</div>
            @endif
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <button type="button" onclick="window.location.href='/register'">Register as Gym Instructor</button>
            <button type="button" onclick="window.location.href='/register-client'">Register as Client</button>
        </form>
    </div>
</body>

</html>