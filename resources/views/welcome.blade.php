<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CFCST Lost and Found Management System</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-black text-white font-sans m-0 p-0 overflow-x-hidden">
        <!-- Background Wrapper -->
        <div class="relative min-h-screen w-full flex flex-col justify-between bg-center bg-no-repeat bg-cover px-8 py-6" style="background-image: url('{{ asset('images/campus-admin.jpg') }}'); background-size: cover; background-repeat: no-repeat;">
            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-black/60"></div>

            <!-- Top Header Area with Sign In pinned to the right -->
            <div class="relative z-10 flex justify-end items-center w-full max-w-7xl mx-auto pt-2">
                <div>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-full shadow-lg transition flex items-center gap-2 text-sm">
                                Dashboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-7 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white font-medium rounded-full shadow-lg transition flex items-center gap-2 text-sm">
                                Sign In &rarr;
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Central Hero Section (Sakto / Medium Size Glassmorphic Logo) -->
            <div class="relative z-10 max-w-4xl mx-auto text-center space-y-4 my-auto">
                <div class="flex justify-center mb-2">
                    <div class="w-12 h-12 p-2.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/25 shadow-xl flex items-center justify-center">
                        <img src="{{ asset('images/cfcst-logo.png') }}" alt="CFCST Logo" class="w-11 h-116 object-contain drop-shadow-md">
                    </div>
                </div>

                <div class="inline-block mb-1">
                    <span class="text-xs tracking-wider uppercase text-emerald-400 font-semibold flex items-center justify-center gap-1">
                        HOW THE PLATFORM WORKS 📌
                    </span>
                </div>
                <div>
                    <div class="inline-block px-5 py-1 bg-emerald-950/90 border border-emerald-500/40 text-emerald-400 font-bold rounded-md text-xs uppercase tracking-widest shadow-md">
                        CFCST
                    </div>
                </div>
                <h1 class="text-4xl sm:text-6xl font-black tracking-widest text-white drop-shadow-md">
                    LOST AND FOUND
                </h1>
                <p class="text-gray-200 text-xs sm:text-sm max-w-2xl mx-auto drop-shadow leading-relaxed">
                    Cotabato Foundation College of Science and Technology Lost & Found System. Securely report, track, and recover belongings across the campus with ease.
                </p>
            </div>

            <!-- Bottom Feature Cards -->
            <div class="relative z-10 max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-5 w-full pb-6">
                <!-- Card 1 -->
                <div class="bg-black/40 backdrop-blur-md border border-white/25 rounded-2xl p-6 text-left shadow-2xl">
                    <h3 class="text-base font-bold text-white mb-2 tracking-wide">1. POST</h3>
                    <p class="text-gray-200 text-xs leading-relaxed">
                        Lost or found something inside the campus? Create a post with photo and details.
                    </p>
                </div>
                <!-- Card 2 -->
                <div class="bg-black/40 backdrop-blur-md border border-white/25 rounded-2xl p-6 text-left shadow-2xl">
                    <h3 class="text-base font-bold text-white mb-2 tracking-wide">2. SEARCH</h3>
                    <p class="text-gray-200 text-xs leading-relaxed">
                        Browse or search for a keyword to view posts related to your things.
                    </p>
                </div>
                <!-- Card 3 -->
                <div class="bg-black/40 backdrop-blur-md border border-white/25 rounded-2xl p-6 text-left shadow-2xl">
                    <h3 class="text-base font-bold text-white mb-2 tracking-wide">3. CONTACT</h3>
                    <p class="text-gray-200 text-xs leading-relaxed">
                        Contact the poster via email, phone number, facebook account and get your things back.
                    </p>
                </div>
            </div>

            <!-- Footer Copyright -->
            <div class="relative z-10 text-center text-xs text-gray-400 pb-1">
                &copy; POWERED BY: Rodel Cañete. ccfcst lost and found
            </div>

        </div>
    </body>
</html>