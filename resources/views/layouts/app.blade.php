<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tambahkan link CSS dan JS yang diperlukan -->
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
</html>

