<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title') - Aplikasi Tracer Study</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        /* Mirip style default error Laravel */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #fff;
            color: #636b6f;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            padding: 20px;
        }
        h1 {
            font-size: 72px;
            font-weight: 600;
            margin: 0;
            color: #dc2626; /* merah */
            letter-spacing: -4px;
        }
        p {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 400;
            color: #636b6f;
        }
        a {
            font-weight: 600;
            color: #636b6f;
            text-decoration: none;
            border: 1px solid #636b6f;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        a:hover {
            background-color: #636b6f;
            color: white;
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 48px;
            }
            p {
                font-size: 18px;
            }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
