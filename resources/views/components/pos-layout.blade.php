<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mini POS') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-800">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-200">
        <div class="mx-auto flex max-w-7xl flex-col lg:flex-row">
            <aside
                class="w-full border-b border-slate-200 bg-slate-900 p-4 text-slate-100 lg:w-72 lg:border-b-0 lg:border-r lg:h-screen lg:sticky lg:top-0 lg:overflow-y-auto">
                <div class="flex items-center justify-between lg:block">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Mini POS</p>
                        <h1 class="mt-2 text-xl font-semibold">Point of Sale</h1>
                    </div>
                    <div class="rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-medium text-emerald-300 lg:mt-3">
                        Live stock</div>
                </div>
                <nav class="mt-6 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Dashboard</a>
                    <a href="{{ route('products.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Products</a>
                    <a href="{{ route('categories.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('categories.*') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Categories</a>
                    <a href="{{ route('purchases.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('purchases.*') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Purchases</a>
                    <a href="{{ route('sales.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('sales.*') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Sales</a>
                    <a href="{{ route('sales.index') }}"
                        class="flex items-center rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('invoices.*') ? 'bg-emerald-500 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">Invoices</a>
                </nav>
            </aside>
            <div class="flex-1">
                <header
                    class="sticky top-0 z-20 border-b border-slate-200 bg-white/90 px-4 py-4 shadow-sm backdrop-blur sm:px-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-emerald-600">
                                {{ Auth::check() ? Auth::user()->name : 'Welcome' }}</p>
                            <h2 class="text-xl font-semibold">{{ $title ?? 'Dashboard' }}</h2>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('products.index') }}"
                                class="rounded-md border border-slate-200 px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Products</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    class="rounded-md bg-slate-900 px-3 py-2 text-sm font-medium text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                </header>
                <main class="p-4 sm:p-6">
                    <div class="mx-auto w-full max-w-7xl">{{ $slot }}</div>
                </main>
            </div>
        </div>
    </div>
</body>

</html>
