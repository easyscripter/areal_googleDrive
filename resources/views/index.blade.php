<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Areal Google Drive</title>
    <link rel="stylesheet" href=" {{ asset('css/app.css') }} ">
</head>
<body>
    <div id="app">
        <App></App>
        @if (session('user.token'))
            <div style="position: absolute; right: 0">
                {{ session('user.token.access_token') }}
            </div>
        @endif
    </div>
    <script src="./js/app.js"></script>
</body>
</html>