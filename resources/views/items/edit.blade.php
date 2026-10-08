<x-app-layout>
    <div class="flex min-h-screen bg-gray-100 text-gray-900 font-sans">
        <!-- Sidebar Navigation -->
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
                    <a href="{{ route('items.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-gray-300 hover:bg-white/10 hover:text-white font-medium text-xs transition"><span>🔍</span> Browse Items</a>
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

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-w-0 overflow-y-auto bg-gray-100">
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-20 shadow-sm">
                <div class="flex items-center gap-2">
                    <h1 class="text-xs font-bold text-emerald-700 tracking-wider uppercase">Edit Campus Item Report</h1>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-xs text-gray-600">Student Portal, <strong class="text-emerald-700">{{ Auth::user()->name }}</strong></span>
                </div>
            </header>

            <div class="p-6 max-w-3xl mx-auto w-full my-auto">
                <div class="bg-white border border-gray-200 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
                    <div>
                        <div class="inline-block px-3 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold rounded-md text-[10px] uppercase tracking-widest shadow-sm mb-2">
                            Update Record
                        </div>
                        <h2 class="text-lg font-black tracking-wide text-gray-800">Edit Lost or Found Details</h2>
                        <p class="text-xs text-gray-500 mt-0.5">Modify information or update your contact details below.</p>
                    </div>

                    <!-- Global Validation Error Alert Box -->
                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl text-xs space-y-1">
                            <strong class="font-bold block">⚠️ Please fix the following errors before submitting:</strong>
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <!-- Item Name & Type Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Item Name / Title</label>
                                <input type="text" name="title" value="{{ old('title', $item->title) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('title') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Report Type</label>
                                <select name="type" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                    <option value="lost" {{ old('type', $item->type) == 'lost' ? 'selected' : '' }}>Lost Item</option>
                                    <option value="found" {{ old('type', $item->type) == 'found' ? 'selected' : '' }}>Found Item</option>
                                </select>
                                @error('type') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Category & Location Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Category</label>
                                <input type="text" name="category" value="{{ old('category', $item->category) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('category') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Location Lost/Found</label>
                                <input type="text" name="location" value="{{ old('location', $item->location) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('location') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Date & Department Row (Added missing department field from controller requirements) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Date Lost/Found</label>
                                <input type="date" name="date" value="{{ old('date', $item->date) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('date') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Department</label>
                                <input type="text" name="department" value="{{ old('department', $item->department) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('department') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Full Name & Student ID (Included to match all required fields in the controller) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Full Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $item->full_name) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('full_name') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Student ID</label>
                                <input type="text" name="student_id" value="{{ old('student_id', $item->student_id) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('student_id') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Detailed Description</label>
                            <textarea name="description" rows="4" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">{{ old('description', $item->description) }}</textarea>
                            @error('description') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Contact Information Section -->
                        <div class="space-y-3 pt-3 border-t border-gray-200">
                            <h3 class="text-xs font-bold uppercase tracking-wider text-emerald-700">Poster Contact Information</h3>
                            
                            <div class="space-y-1.5">
                                <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Facebook Profile Link <span class="text-gray-400 font-normal">(Optional)</span></label>
                                <input type="text" name="facebook_link" value="{{ old('facebook_link', $item->facebook_link) }}" placeholder="e.g., https://facebook.com/yourprofile" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                @error('facebook_link') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Contact Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="contact_number" value="{{ old('contact_number', $item->contact_number) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                    @error('contact_number') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">Email Address <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', $item->email) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-gray-800 focus:outline-none focus:border-emerald-600 text-xs transition">
                                    @error('email') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Item Photos Option -->
                        <div class="space-y-2 pt-3 border-t border-gray-200">
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-gray-700">
                                Replace Photos (Optional - leave blank to keep existing photos)
                            </label>
                            <input type="file" name="images[]" multiple accept="image/*" 
                                class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition cursor-pointer bg-gray-50 border border-gray-300 rounded-xl">
                            @error('images') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                            @error('images.*') <span class="text-[10px] text-red-500 block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('items.index') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-xs font-semibold transition">Cancel</a>
                            <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl text-xs font-semibold shadow-sm transition tracking-wide">Update Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>