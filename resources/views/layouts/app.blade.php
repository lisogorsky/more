<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Море Событий' }}</title>

    {{-- Livewire стили --}}
    @livewireStyles

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    {{-- Свои стили --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>

    {{-- Header --}}
    @include('components.layouts.header')

    {{-- Livewire Modals --}}
    @livewire('auth.register-modal')
    @livewire('auth.forgot-password-modal')

    {{-- Основной контент --}}
    <main class="container my-4">
        @isset($slot)
            {{ $slot }}
        @else
            @yield('content')
        @endisset
    </main>

    {{-- Footer --}}
    @include('components.layouts.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    {{-- Livewire скрипты --}}
    @livewireScripts

    {{-- 🔥 ОТКРЫТИЕ МОДАЛКИ ЛОГИНА --}}
    @if (session('open-login-modal'))
        <script>
            document.addEventListener('livewire:init', () => {
                setTimeout(() => {
                    Livewire.dispatch('show-register-modal')
                }, 0)
            })
        </script>
    @endif

    {{-- Trix редактор --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

    {{-- Свои скрипты --}}
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
