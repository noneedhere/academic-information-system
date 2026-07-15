<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="SIAKAD — Academic Information System for managing students, attendance, and billing.">

    <title>{{ $title ?? 'Dashboard' }} — {{ config('app.name', 'SIAKAD') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">
    {{-- Mobile sidebar overlay --}}
    <div id="sidebar-overlay" class="sidebar-overlay hidden opacity-0 lg:hidden"></div>

    {{-- Sidebar --}}
    @include('components.sidebar')

    {{-- Main content area --}}
    <div class="main-content">
        {{-- Top navbar --}}
        @include('components.navbar')

        {{-- Flash messages --}}
        <div class="px-4 sm:px-6 lg:px-8 pt-4">
            @include('components.alert')
        </div>

        {{-- Page content --}}
        <main class="px-4 sm:px-6 lg:px-8 py-6 animate-fade-in">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
