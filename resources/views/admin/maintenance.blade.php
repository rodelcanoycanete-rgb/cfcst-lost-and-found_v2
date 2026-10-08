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
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition">
                        <span>📈</span> Reports
                    </a>
                    <a href="{{ route('admin.maintenance') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-700/40 text-emerald-300 font-medium text-xs transition">
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
                        <input type="text" placeholder="Search maintenance settings..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-1.5 text-xs text-gray-800 placeholder-gray-400 focus:outline-none focus:border-emerald-600">
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600">Welcome, <strong class="text-emerald-700">{{ Auth::user()->name ?? 'Admin' }}</strong></span>
                </div>
            </header>

            <!-- Page Body -->
            <div class="p-6 space-y-6 max-w-7xl mx-auto w-full">
                <div class="flex justify-between items-center">
                    <h1 class="text-lg font-bold tracking-wide text-gray-800">System Maintenance & Data Control</h1>
                    <span class="text-xs text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-md font-medium">Admin Panel</span>
                </div>

                <!-- Success Alert Message -->
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Danger Zone: Database Reset Box -->
                <div class="bg-white border-2 border-red-200 rounded-2xl p-6 shadow-sm space-y-5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-600 text-base shrink-0 font-bold">
                            ⚠️
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-red-700 uppercase tracking-wider">Danger Zone: System Reset</h2>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                This action is permanent and irreversible. It will wipe all item records and non-admin user accounts from the MySQL database, resetting all dashboard counters completely back to zero.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('admin.system.reset') }}" method="POST" class="space-y-4 pt-2 border-t border-gray-100" onsubmit="return confirm('FINAL WARNING: You are about to wipe all database records. Click OK to proceed.');">
                        @csrf
                        @method('DELETE')

                        <!-- Safety Checkbox Requirement -->
                        <div class="flex items-center gap-2">
                            <input type="checkbox" id="confirmReset" onchange="toggleResetButton()" class="w-4 h-4 text-red-600 border-gray-300 rounded focus:ring-red-500 cursor-pointer">
                            <label for="confirmReset" class="text-xs font-medium text-gray-700 cursor-pointer select-none">
                                I understand that this action deletes all system records and cannot be undone.
                            </label>
                        </div>

                        <!-- Reset Button (Disabled by default until checkbox is checked) -->
                        <div>
                            <button type="submit" id="resetBtn" disabled class="px-5 py-2.5 bg-gray-300 text-gray-500 rounded-xl text-xs font-bold transition shadow-sm cursor-not-allowed">
                                🗑️ Reset Database (Wipe All Records)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript to toggle button state safely -->
    <script>
        function toggleResetButton() {
            const checkbox = document.getElementById('confirmReset');
            const btn = document.getElementById('resetBtn');
            
            if (checkbox.checked) {
                btn.disabled = false;
                btn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
                btn.classList.add('bg-red-600', 'hover:bg-red-500', 'text-white', 'cursor-pointer', 'shadow-md');
            } else {
                btn.disabled = true;
                btn.classList.remove('bg-red-600', 'hover:bg-red-500', 'text-white', 'cursor-pointer', 'shadow-md');
                btn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
            }
        }
    </script>
</x-app-layout>