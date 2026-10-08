<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 text-gray-900 font-sans">
        <aside class="w-64 bg-[#0d2818] text-white hidden md:flex flex-col justify-between p-4 shadow-md">
            <div class="space-y-6">
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

                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition"><span>📊</span> Dashboard</a>
                    <a href="{{ route('items.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-emerald-700/40 text-emerald-300 font-medium text-xs transition"><span>🔍</span> Browse Items</a>
                    <a href="{{ route('items.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition"><span>➕</span> Report Lost/Found</a>
                </nav>
            </div>
            
            <div class="pt-4 border-t border-white/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-300 hover:bg-red-500/25 font-medium text-xs transition">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-gray-100">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-xs font-bold text-emerald-700 tracking-wider uppercase">Campus Lost & Found Feed</h1>
                </div>
                <!-- Removed Student Portal text here -->
                <div class="flex items-center gap-4"></div>
            </header>

            <div class="p-6 max-w-7xl mx-auto w-full space-y-6">
                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-2xl text-xs font-bold shadow-sm flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="text-emerald-600 text-sm">✨</span> {{ session('success') }}
                        </span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-2xl text-xs font-bold shadow-sm flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <span class="text-red-600 text-sm">⚠️</span> {{ session('error') }}
                        </span>
                    </div>
                @endif

                <div class="bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                    <form method="GET" action="{{ route('items.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-2">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, description, or location..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-xs focus:outline-none focus:border-emerald-600">
                        </div>
                        <div>
                            <select name="status" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-emerald-600">
                                <option value="">All Statuses</option>
                                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost Items</option>
                                <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>Found Items</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold py-2 transition">Filter</button>
                            <a href="{{ route('items.index') }}" class="px-3 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-xs font-semibold transition flex items-center justify-center">Reset</a>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @forelse($items as $item)
                        @php
                            $images = is_string($item->images) ? json_decode($item->images, true) : ($item->images ?? []);
                        @endphp
                        <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm flex flex-col justify-between space-y-4">
                            <div class="space-y-3">
                                @if(!empty($images) && count($images) > 0)
                                    <div class="space-y-2">
                                        <!-- Main Featured Image -->
                                        <div class="w-full h-40 bg-gray-100 rounded-xl overflow-hidden border border-gray-200">
                                            <img src="{{ asset('storage/' . $images[0]) }}" 
                                                 alt="{{ $item->title }}" 
                                                 class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300 modal-trigger-img"
                                                 data-image="{{ asset('storage/' . $images[0]) }}">
                                        </div>
                                        
                                        <!-- Additional Angle Photos Grid -->
                                        @if(count($images) > 1)
                                            <div class="grid grid-cols-3 gap-2">
                                                @foreach(array_slice($images, 1, 3) as $additionalImage)
                                                    <div class="h-16 bg-gray-100 rounded-lg overflow-hidden border border-gray-200">
                                                        <img src="{{ asset('storage/' . $additionalImage) }}" 
                                                             alt="Angle photo" 
                                                             class="w-full h-full object-cover cursor-pointer hover:scale-105 transition-transform duration-300 modal-trigger-img"
                                                             data-image="{{ asset('storage/' . $additionalImage) }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between">
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $item->type == 'lost' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }}">
                                        {{ $item->type }}
                                    </span>
                                    <span class="text-[10px] text-gray-400">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold {{ $item->is_reported ? 'text-red-600 italic' : 'text-gray-800' }}">{{ $item->title }}</h3>
                                    <p class="text-xs text-emerald-700 font-medium mt-0.5">📍 {{ $item->location }}</p>
                                    <p class="text-xs {{ $item->is_reported ? 'text-red-500 italic' : 'text-gray-600' }} mt-2 line-clamp-2">{{ $item->description }}</p>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-100 space-y-2">
                                @if($item->facebook_link || $item->contact_number || $item->email || $item->full_name || $item->department)
                                    <div class="bg-gray-50 rounded-xl p-2.5 border border-gray-200 text-[11px] space-y-1">
                                        <span class="font-bold text-gray-700 block uppercase text-[10px]">Contact Poster:</span>
                                        
                                        @if($item->full_name)
                                            <div class="text-gray-700 font-semibold flex items-center gap-1.5">
                                                <span>👤</span> {{ $item->full_name }}
                                            </div>
                                        @endif

                                        @if($item->department)
                                            <div class="text-emerald-700 font-semibold flex items-center gap-1.5">
                                                <span>🏛️</span> Department: {{ $item->department }}
                                            </div>
                                        @endif

                                        @if($item->facebook_link)
                                            <a href="{{ $item->facebook_link }}" target="_blank" class="flex items-center gap-1.5 text-blue-600 hover:underline font-medium truncate">
                                                <span>💬</span> Facebook Profile / Chat
                                            </a>
                                        @endif
                                        @if($item->contact_number)
                                            <div class="text-gray-600 flex items-center gap-1.5">
                                                <span>📞</span> {{ $item->contact_number }}
                                            </div>
                                        @endif
                                        @if($item->email)
                                            <div class="text-gray-600 flex items-center gap-1.5 truncate">
                                                <span>✉️</span> {{ $item->email }}
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center justify-between text-[11px] text-gray-500 pt-1">
                                    <span>Category: <strong>{{ $item->category }}</strong></span>
                                    <span>By: {{ $item->user->name ?? 'Anonymous' }}</span>
                                </div>

                                <div class="pt-2 flex items-center justify-between">
                                    @if(Auth::id() === $item->user_id)
                                        <div class="w-full flex items-center justify-end gap-2">
                                            <a href="{{ route('items.edit', $item->id) }}" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-emerald-50 hover:text-emerald-700 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-200 transition">
                                                <span>✏️</span> Edit
                                            </a>
                                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-lg border border-red-200 transition">
                                                    <span>🗑️</span> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        @if(!$item->is_reported)
                                            <form action="{{ route('items.report', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to report this post for inappropriate content? This will hide the text details.');">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 text-red-600 text-[11px] font-semibold px-2.5 py-1.5 rounded-lg border border-red-200 transition">
                                                    <span>🚩</span> Report Inappropriate
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-[11px] text-red-500 font-semibold italic">Reported / Hidden Content</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 bg-white border border-gray-200 rounded-2xl p-12 text-center space-y-2">
                            <p class="text-sm font-bold text-gray-700">No items found</p>
                            <p class="text-xs text-gray-400">Try adjusting your filters or report a new lost/found item.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            </div>
        </main>
    </div>

    <!-- Original Size Image Modal Viewer -->
    <div id="originalImageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 hidden p-4 overflow-auto">
        <div class="relative max-w-5xl max-h-[90vh] flex items-center justify-center m-auto" onclick="event.stopPropagation()">
            <!-- Close Button -->
            <button type="button" id="closeModalBtn" class="absolute -top-10 right-0 text-white text-4xl font-bold hover:text-gray-300 focus:outline-none p-2 z-50 cursor-pointer">&times;</button>
            
            <!-- Full / Original Size View Image -->
            <img id="originalModalImg" src="" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl object-contain bg-black">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('originalImageModal');
            const modalImg = document.getElementById('originalModalImg');
            const closeBtn = document.getElementById('closeModalBtn');

            const imageTriggers = document.querySelectorAll('.modal-trigger-img');
            imageTriggers.forEach(function(img) {
                img.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const imagePath = this.getAttribute('data-image');
                    if (modal && modalImg && imagePath) {
                        modalImg.src = imagePath;
                        modal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                    }
                });
            });

            function closeModal() {
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }

            if (closeBtn) {
                closeBtn.addEventListener('click', closeModal);
            }

            if (modal) {
                modal.addEventListener('click', closeModal);
            }

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
</x-app-layout>