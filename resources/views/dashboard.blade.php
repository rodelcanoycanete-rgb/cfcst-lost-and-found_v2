<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 text-gray-900">
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-[#0d2818] text-white hidden md:flex flex-col justify-between p-4 shadow-md">
            <div class="space-y-6">
                <!-- Brand / Logo -->
                <div class="flex items-center gap-2 px-2 pt-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center font-bold text-white text-xs">
                        C
                    </div>
                    <span class="text-emerald-400 font-bold tracking-wider text-sm">CFCST PORTAL</span>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/10 hover:text-white' }} font-medium text-xs transition">
                        <span>📊</span> Dashboard
                    </a>
                    <a href="{{ route('admin.lost-items') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.lost-items*') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/10 hover:text-white' }} font-medium text-xs transition">
                        <span>🔍</span> Lost Items
                    </a>
                    <a href="{{ route('admin.found-items') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.found-items*') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/10 hover:text-white' }} font-medium text-xs transition">
                        <span>✅</span> Found Items
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.users*') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/10 hover:text-white' }} font-medium text-xs transition">
                        <span>👥</span> Users
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.reports*') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/10 hover:text-white' }} font-medium text-xs transition">
                        <span>📈</span> Reports
                    </a>
                    <a href="{{ route('admin.maintenance') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('admin.maintenance*') ? 'bg-emerald-700/40 text-emerald-300' : 'text-gray-300 hover:bg-white/15 hover:text-white' }} font-medium text-xs transition">
                        <span>⚙️</span> System Maintenance
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer / Logout -->
            <div class="pt-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/20 font-medium text-xs transition">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Canvas -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Top Header Bar -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-4 w-1/3">
                    <div class="relative w-full max-w-xs">
                        <input type="text" placeholder="Search items, users..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-1.5 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-emerald-600">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600">Welcome, <strong class="text-emerald-700">{{ Auth::user()->name ?? 'Admin' }}</strong></span>
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="p-6 space-y-6 max-w-7xl mx-auto w-full">
                <!-- Page Title & Small Welcome Message -->
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg font-bold tracking-wide text-gray-800">System Dashboard</h1>
                        <p class="text-xs text-gray-500 mt-0.5">👋 Welcome back, Admin! Hope you're having a productive day managing the portal.</p>
                    </div>
                    <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-md font-medium">Live Overview</span>
                </div>

                <!-- 4 Metric Summary Cards Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Total Lost Items</span>
                        <div class="text-2xl font-black text-gray-800">{{ $totalLostItems ?? 0 }}</div>
                        <span class="text-[10px] text-emerald-600 font-medium">Live Database Count</span>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Found Items</span>
                        <div class="text-2xl font-black text-emerald-700">{{ $foundItems ?? 0 }}</div>
                        <span class="text-[10px] text-emerald-600 font-medium">75% Recovery Rate</span>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Claimed Items</span>
                        <div class="text-2xl font-black text-gray-800">{{ $claimedItems ?? 0 }}</div>
                        <span class="text-[10px] text-gray-500">Successfully returned</span>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-2">
                        <span class="text-xs text-gray-500 font-medium">Active Users</span>
                        <div class="text-2xl font-black text-gray-800">{{ $activeUsers ?? 0 }}</div>
                        <span class="text-[10px] text-emerald-600 font-medium">Registered Accounts</span>
                    </div>
                </div>

                <!-- Grid Section for Analytics / Tables -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Recent Activity Panel -->
                    <div class="lg:col-span-2 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
                        <h2 class="text-sm font-bold text-gray-800">Recent Postings Activity</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-600"></div>
                                    <span class="text-gray-700">Student ID Lost near Admin Building</span>
                                </div>
                                <span class="text-gray-400 text-[10px]">10 mins ago</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100 text-xs">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full bg-emerald-600"></div>
                                    <span class="text-gray-700">Found Calculator at Engineering Lab</span>
                                </div>
                                <span class="text-gray-400 text-[10px]">1 hour ago</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Panel -->
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
                        <h2 class="text-sm font-bold text-gray-800">Quick Actions</h2>
                        <div class="space-y-2">
                            <button class="w-full py-2 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                                + Create New Post
                            </button>
                            <button class="w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-xs font-semibold transition">
                                View All Reports
                            </button>
                        </div>
                    </div>
                </div>

                <!-- External Weather API Dashboard Widget (At the Bottom, Side-by-Side Grid Layout) -->
                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-5">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-sm font-bold text-gray-800">🌤️ Live Weather Dashboard</h2>
                            <p class="text-xs text-gray-500">Weather API Integration</p>
                        </div>

                        <!-- Location Search Form -->
                        <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 w-full sm:w-auto">
                            <input type="text" name="city" value="{{ $city ?? 'Kidapawan' }}" placeholder="Search city or location..." 
                                class="bg-gray-50 border border-gray-300 rounded-xl px-3 py-1.5 text-xs text-gray-800 focus:outline-none focus:border-emerald-600 w-full sm:w-60">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-500 text-white px-4 py-1.5 rounded-xl text-xs font-semibold transition shrink-0">
                                Search
                            </button>
                        </form>
                    </div>

                    @if(isset($weatherData) && $weatherData)
                        <!-- 5 Side-by-Side Horizontal Columns -->
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 pt-1">
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center space-y-1">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Location</span>
                                <span class="text-xs font-bold text-gray-800 truncate block">{{ $weatherData['location']['name'] ?? 'N/A' }}</span>
                                <span class="text-[10px] text-gray-500 block">{{ $weatherData['location']['country'] ?? '' }}</span>
                            </div>
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center space-y-1">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Temperature</span>
                                <span class="text-sm font-black text-emerald-700 block">{{ $weatherData['current']['temp_c'] ?? 0 }}°C</span>
                                <span class="text-[10px] text-gray-500 block">Current temp</span>
                            </div>
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center space-y-1">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Condition</span>
                                <span class="text-xs font-bold text-gray-800 capitalize truncate block">{{ $weatherData['current']['condition']['text'] ?? 'N/A' }}</span>
                                <span class="text-[10px] text-gray-500 block">Sky status</span>
                            </div>
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center space-y-1">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Humidity</span>
                                <span class="text-xs font-bold text-gray-800 block">{{ $weatherData['current']['humidity'] ?? 0 }}%</span>
                                <span class="text-[10px] text-gray-500 block">Moisture level</span>
                            </div>
                            <div class="bg-gray-50 p-3.5 rounded-xl border border-gray-100 text-center space-y-1 col-span-2 md:col-span-1">
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Wind Speed</span>
                                <span class="text-xs font-bold text-gray-800 block">{{ $weatherData['current']['wind_kph'] ?? 0 }} km/h</span>
                                <span class="text-[10px] text-gray-500 block">Air movement</span>
                            </div>
                        </div>
                    @else
                        <!-- Fallback Message if API Fails or Times Out -->
                        <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-amber-800 text-xs text-center">
                            ⚠️ Weather information is currently unavailable or the location was not found. Please try searching again later.
                        </div>
                    @endif
                </div>

            </div>
        </main>
    </div>
</x-app-layout>