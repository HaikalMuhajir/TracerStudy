<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            background-image: url('https://memontum.com/wp-content/uploads/2020/03/Polinema-Kuliah-dari-Rumah-Mulai-17-27-Maret-2020.jpg'); /* Add the image URL */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Keeps the background fixed while scrolling */
            background-color: #000000; /* Solid black background */

        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5); /* Optional: adds a dark overlay for better text visibility */
        }

        .login-box {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            max-width: 100%;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-group input:focus {
            border-color: #4c51bf;
            outline: none;
        }

        .btn-submit {
            width: 100%;
            background-color: #4c51bf;
            color: white;
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #434190;
        }

        .text-center {
            text-align: center;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="login-box">
            <h2>{{ $pageTitle }}</h2>
            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.login.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn-submit">Login</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
