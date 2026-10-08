<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign In - CFCST Lost and Found System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-black text-white font-sans m-0 p-0 overflow-x-hidden">
        <!-- Background Wrapper with subtle dark vignette -->
        <div class="relative min-h-screen w-full flex flex-col justify-between bg-center bg-no-repeat bg-cover px-8 py-6" style="background-image: url('{{ asset('images/campus-admin.jpg') }}'); background-size: cover; background-repeat: no-repeat;">
            
            <!-- Vignette Overlay: smooth dark outer edges, lighter transparent center -->
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(0,0,0,0.25)_0%,rgba(0,0,0,0.85)_100%)]"></div>

            <!-- Top Header Area -->
            <div class="relative z-10 flex justify-between items-center w-full max-w-7xl mx-auto pt-2">
                <div>
                    <a href="{{ url('/') }}" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-full shadow-lg transition flex items-center gap-2 text-xs">
                        &larr; Back to Home
                    </a>
                </div>
            </div>

            <!-- Central Compact Glassmorphism Card -->
            <div class="relative z-10 w-full max-w-lg mx-auto bg-gradient-to-b from-gray-900/80 via-gray-900/60 to-black/80 backdrop-blur-md border border-white/20 rounded-3xl p-6 sm:p-8 shadow-2xl space-y-5 my-auto">
                
                <!-- Card Header -->
                <div class="text-center space-y-2">
                    <div class="inline-block px-4 py-0.5 bg-emerald-950/90 border border-emerald-500/40 text-emerald-400 font-bold rounded-md text-[10px] uppercase tracking-widest shadow-md">
                        CFCST PORTAL
                    </div>
                    <h1 class="text-2xl font-black tracking-wide text-white">
                        Sign In to Your Account
                    </h1>
                    <p class="text-gray-300 text-xs">
                        Enter your credentials to manage reports and items.
                    </p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="text-xs font-medium text-emerald-400 text-center bg-emerald-950/50 py-2 rounded-xl border border-emerald-500/30">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4 max-w-md mx-auto w-full">
                    @csrf

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="user@gmail.com" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('email')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('password')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Options Row -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-gray-300 cursor-pointer">
                            <input type="checkbox" name="remember" class="rounded bg-black/50 border-white/25 text-emerald-600 focus:ring-emerald-500 w-3.5 h-3.5">
                            <span class="ml-2 text-[11px]">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-emerald-400 hover:text-emerald-300 transition text-[11px]">Forgot password?</a>
                        @endif
                    </div>

                    <!-- Sign In Button -->
                    <div class="pt-1">
                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition text-xs tracking-wide">
                            Sign In
                        </button>
                    </div>

                    <!-- Google Sign In Button (Inserted Here) -->
                    <div class="pt-1">
                        <div class="relative flex py-1 items-center">
                            <div class="flex-grow border-t border-white/20"></div>
                            <span class="flex-shrink mx-4 text-gray-400 text-[10px] uppercase tracking-wider">Or</span>
                            <div class="flex-grow border-t border-white/20"></div>
                        </div>

                        <a href="{{ route('google.login') }}" class="w-full flex items-center justify-center px-4 py-2.5 bg-black/60 hover:bg-black/80 border border-white/25 rounded-xl text-white font-semibold shadow-lg transition text-xs tracking-wide gap-3">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.13 0-5.78-2.11-6.73-4.96H1.18v3.14C3.16 21.32 7.23 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.27 14.24c-.25-.72-.38-1.49-.38-2.24s.13-1.52.38-2.24V6.62H1.18C.43 8.13 0 9.83 0 12s.43 3.87 1.18 5.38l4.09-3.14z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.23 0 3.16 2.68 1.18 6.62l4.09 3.14c.95-2.85 3.6-4.96 6.73-4.96z"/>
                            </svg>
                            Sign in with Google
                        </a>
                    </div>

                    <!-- Navigation Link -->
                    <div class="text-center pt-1 text-xs text-gray-400">
                        Don't have an account? <a href="{{ route('register') }}" class="text-emerald-400 font-semibold hover:underline">Register</a>
                    </div>
                </form>
            </div>

            <!-- Footer Copyright -->
            <div class="relative z-10 text-center text-xs text-gray-400 pb-1">
                &copy; POWERED BY: Rodel Cañete.
            </div>

        </div>
    </body>
</html>