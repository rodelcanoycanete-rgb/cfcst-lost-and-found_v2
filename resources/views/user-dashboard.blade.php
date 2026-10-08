<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 text-gray-900 font-sans">
        <!-- Sidebar Navigation for Users -->
        <aside class="w-64 bg-[#0d2818] text-white hidden md:flex flex-col justify-between p-4 shadow-md">
            <div class="space-y-6">
                <!-- Dynamic User Profile & Name Sidebar Header -->
                <div class="flex items-center gap-3 px-2 pt-2">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}" class="w-9 h-9 rounded-xl object-cover border border-emerald-500/40 shadow-sm">
                    @else
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 flex items-center justify-center font-bold text-white text-xs shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex flex-col min-w-0">
                        <span class="text-emerald-400 font-bold tracking-wider text-xs truncate max-w-[130px]">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-gray-300">CFCST Account</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-700/40 text-emerald-300 font-medium text-xs transition">
                        <span>📊</span> My Dashboard
                    </a>
                    <a href="{{ route('items.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>🔍</span> Browse Items
                    </a>
                    <a href="{{ route('items.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>➕</span> Report Lost/Found
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer / Logout -->
            <div class="pt-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/25 font-medium text-xs transition">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Canvas -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-gray-100">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-4 w-1/3">
                    <div class="relative w-full max-w-xs">
                        <input type="text" placeholder="Search lost items..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-1.5 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-emerald-600">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600">Student Portal, <strong class="text-emerald-700">{{ Auth::user()->name }}</strong></span>
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="p-6 space-y-6 max-w-7xl mx-auto w-full">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg font-bold tracking-wide text-gray-800">My Student Dashboard</h1>
                    <a href="{{ route('items.create') }}" class="px-4 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center gap-2">
                        + Report Item
                    </a>
                </div>

                <!-- User Metric Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">My Active Reports</span>
                        <div class="text-2xl font-black text-gray-800">2</div>
                        <span class="text-[10px] text-emerald-600 font-medium">Pending verification</span>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Items Claimed</span>
                        <div class="text-2xl font-black text-emerald-700">1</div>
                        <span class="text-[10px] text-emerald-600 font-medium">Successfully returned</span>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Browse All Campus Items</span>
                        <div class="text-lg font-bold text-gray-800"><a href="{{ route('items.index') }}" class="text-emerald-600 hover:underline">View Feed &rarr;</a></div>
                        <span class="text-[10px] text-gray-400">Check what was found</span>
                    </div>
                </div>

                <!-- Recent User Activity -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="text-sm font-bold text-gray-800">My Reported Items</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 text-xs">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                <span class="text-gray-700">Black Umbrella Lost at Gymnasium</span>
                            </div>
                            <span class="text-amber-600 text-[10px] bg-amber-50 px-2.5 py-1 rounded-lg border border-amber-200 font-medium">Pending Review</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>