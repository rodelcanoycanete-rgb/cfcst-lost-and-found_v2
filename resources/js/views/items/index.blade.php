<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Lost & Found Board') }}
            </h2>
            <a href="{{ route('items.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                + Report Item
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 text-emerald-700 rounded-r-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Search and Filter Bar -->
            <div class="bg-white p-4 sm:p-6 rounded-xl shadow-sm border border-gray-100">
                <form method="GET" action="{{ route('items.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search items..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                    </div>
                    <div>
                        <select name="status" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm text-sm">
                            <option value="">All Statuses</option>
                            <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                            <option value="found" {{ request('status') == 'found' ? 'selected' : '' }}>Found</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">Filter</button>
                        <a href="{{ route('items.index') }}" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm font-medium hover:bg-gray-200 transition text-center">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($items as $item)
                    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 flex flex-col justify-between">
                        <div>
                            @if($item->image_path)
                                <div class="h-48 overflow-hidden bg-gray-100">
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->item_name }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                                </div>
                            @else
                                <div class="h-48 bg-gray-50 flex items-center justify-center text-gray-400 text-sm">
                                    No Image Available
                                </div>
                            @endif
                            
                            <div class="p-5 space-y-3">
                                <div class="flex justify-between items-start">
                                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full {{ $item->status == 'lost' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                        {{ $item->status }}
                                    </span>
                                    <span class="text-xs text-gray-500 font-medium">{{ $item->category }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 leading-snug">{{ $item->item_name }}</h3>
                                <p class="text-xs text-gray-500 flex items-center gap-1">
                                    📍 {{ $item->location }}
                                </p>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ $item->description }}</p>
                            </div>
                        </div>
                        
                        <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                            <span>By {{ $item->user->name }}</span>
                            <span>{{ $item->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12 bg-white rounded-xl border border-gray-100 shadow-sm">
                        <p class="text-gray-500 text-sm">No items found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $items->withQueryString()->links() }}
            </div>

        </div>
    </div>
</x-app-layout>