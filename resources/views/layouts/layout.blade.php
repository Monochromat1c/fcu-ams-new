<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @yield('content')

    @include('layouts.modals.logout')
    <script src="{{ asset('js/successMessageTimer.js') }}"></script>
    <script src="{{ asset('js/errorMessageTimer.js') }}"></script>
    <script src="{{ asset('js/sidebarLinkDropdownScript.js') }}"></script>
    <script src="{{ asset('js/alpine.min.js') }}" defer></script>
</body>

</html>
