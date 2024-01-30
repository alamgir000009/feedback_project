<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script type="text/javascript" src=https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js></script>
</head>

<body class="background-dom">
    <div id="app">
    </div>
    @vite('resources/js/app.js')
</body>

</html>
