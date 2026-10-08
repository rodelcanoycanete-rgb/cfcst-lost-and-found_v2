<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CFCST Lost and Found System</title>
    <!-- Tailwind CSS CDN for simple styling -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
            <a href="{{ route('items.index') }}" class="text-xl font-bold text-blue-600">CFCST Lost & Found</a>
            <div class="flex items-center space-x-4">
                @auth
                    <a href="{{ route('items.create') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Report Item</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">Manage Categories</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-blue-600 hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>