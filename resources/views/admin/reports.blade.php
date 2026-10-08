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
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>📊</span> Dashboard
                    </a>
                    <a href="{{ route('admin.lost-items') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>🔍</span> Lost Items
                    </a>
                    <a href="{{ route('admin.found-items') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>✅</span> Found Items
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>👥</span> Users
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-700/40 text-emerald-300 font-medium text-xs transition">
                        <span>📈</span> Reports
                    </a>
                    <a href="{{ route('admin.maintenance') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
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
                        <input type="text" placeholder="Search reports..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-1.5 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-emerald-600">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600">Welcome, <strong class="text-emerald-700">{{ Auth::user()->name ?? 'Admin' }}</strong></span>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-6 space-y-6 max-w-7xl mx-auto w-full">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg font-bold tracking-wide text-gray-800">System Reports & Analytics</h1>
                    <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-md font-medium">Admin Panel</span>
                </div>

                <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-3">
                    <h2 class="text-sm font-bold text-gray-800">Activity Analytics</h2>
                    <p class="text-xs text-gray-600">Overview of item recovery rates, campus posting distributions, and user engagement metrics will be generated here.</p>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>