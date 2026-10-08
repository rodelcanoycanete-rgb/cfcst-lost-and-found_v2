<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register - CFCST Lost and Found System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-black text-white font-sans m-0 p-0 overflow-x-hidden">
        <!-- Background Wrapper with subtle dark vignette matching Login -->
        <div class="relative min-h-screen w-full flex flex-col justify-between bg-center bg-no-repeat bg-cover px-8 py-6" style="background-image: url('{{ asset('images/campus-admin.jpg') }}'); background-size: cover; background-repeat: no-repeat;">
            
            <!-- Vignette Overlay -->
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
                        Create an Account
                    </h1>
                    <p class="text-gray-300 text-xs">
                        Fill in your details to register for the portal.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-4 max-w-md mx-auto w-full">
                    @csrf

                    <!-- Name Input -->
                    <div class="space-y-1.5">
                        <label for="name" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Full Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Rodel Cañete" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('name')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="space-y-1.5">
                        <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="user@gmail.com" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('email')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="space-y-1.5">
                        <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('password')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-wider text-gray-200">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="w-full px-4 py-2.5 bg-black/60 border border-white/25 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-xs transition">
                        @error('password_confirmation')
                            <span class="text-[10px] text-red-400 block mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Register Button -->
                    <div class="pt-1">
                        <button type="submit" class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-xl shadow-lg transition text-xs tracking-wide">
                            Register
                        </button>
                    </div>

                    <!-- Navigation Link -->
                    <div class="text-center pt-1 text-xs text-gray-400">
                        Already have an account? <a href="{{ route('login') }}" class="text-emerald-400 font-semibold hover:underline">Sign In</a>
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