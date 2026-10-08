<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // Display a listing of items (Feed & Search)
    public function index(Request $request)
    {
        $query = Item::with('user')->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('type', $request->status);
        }

        $items = $query->paginate(10)->withQueryString();
        return view('items.index', compact('items'));
    }

    // Show the form for creating a new item report
    public function create()
    {
        return view('items.create');
    }

    // Store a newly created item in the database
    public function store(Request $request)
    {
        // Clean up empty or invalid file slots so 'images.*' never triggers an index error
        if ($request->hasFile('images')) {
            $validFiles = array_filter($request->file('images'), function ($file) {
                return $file instanceof \Illuminate\Http\UploadedFile && $file->isValid();
            });
            // Reset array keys sequentially (0, 1, 2...) to prevent index gaps
            $request->files->set('images', array_values($validFiles));
        } else {
            $request->files->set('images', []);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'facebook_link' => 'nullable|url|max:255', 
            'contact_number' => 'required|string|max:50', 
            'email' => 'required|email|max:255', 
            'images' => 'required|array|min:1|max:4', 
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480', // 20MB limit
        ]);

        $imagePaths = [];
        foreach ($validated['images'] as $file) {
            $path = $file->store('items', 'public');
            $imagePaths[] = $path;
        }

        Item::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'location' => $validated['location'],
            'date' => $validated['date'],
            'full_name' => $validated['full_name'],
            'student_id' => $validated['student_id'],
            'department' => $validated['department'],
            'facebook_link' => $validated['facebook_link'] ?? null,
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
            'images' => json_encode($imagePaths),
            'status' => 'pending',
            'is_reported' => false,
            'report_count' => 0,
        ]);

        return redirect()->route('items.index')->with('success', '🎉 Successfully Posted! Your item report has been published.');
    }

    // Handle reporting inappropriate text/content
    public function report($id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id === Auth::id()) {
            return redirect()->route('items.index')->with('error', 'You cannot report your own post.');
        }

        $item->increment('report_count');
        $item->update([
            'is_reported' => true,
            'title' => '[Content Removed Due to Report]',
            'description' => 'This description has been hidden because it was reported for containing inappropriate text or elements.',
            'location' => '[Hidden Location]',
        ]);

        return redirect()->route('items.index')->with('success', 'Post has been reported. Inappropriate text has been removed.');
    }

    // Show the form for editing an existing item report
    public function edit($id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id !== Auth::id()) {
            return redirect()->route('items.index')->with('error', 'Unauthorized action.');
        }

        return view('items.edit', compact('item'));
    }

    // Update the specified item in the database
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id !== Auth::id()) {
            return redirect()->route('items.index')->with('error', 'Unauthorized action.');
        }

        // Clean up empty or invalid file slots for update as well
        if ($request->hasFile('images')) {
            $validFiles = array_filter($request->file('images'), function ($file) {
                return $file instanceof \Illuminate\Http\UploadedFile && $file->isValid();
            });
            $request->files->set('images', array_values($validFiles));
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:lost,found',
            'category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'facebook_link' => 'nullable|url|max:255', 
            'contact_number' => 'required|string|max:50', 
            'email' => 'required|email|max:255', 
            'images' => 'sometimes|array|max:4', // Removed min:1 so editing text-only doesn't crash
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:20480', // 20MB limit
        ]);

        $imagePaths = is_string($item->images) ? json_decode($item->images, true) : ($item->images ?? []);

        // Only replace and delete old images if user actually uploaded new ones
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            foreach ($imagePaths as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            $imagePaths = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('items', 'public');
                $imagePaths[] = $path;
            }
        }

        $item->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'location' => $validated['location'],
            'date' => $validated['date'],
            'full_name' => $validated['full_name'],
            'student_id' => $validated['student_id'],
            'department' => $validated['department'],
            'facebook_link' => $validated['facebook_link'] ?? null,
            'contact_number' => $validated['contact_number'],
            'email' => $validated['email'],
            'images' => json_encode($imagePaths),
        ]);

        return redirect()->route('items.index')->with('success', '✨ Item report updated successfully!');
    }

    // Remove the specified item from the database
    public function destroy($id)
    {
        $item = Item::findOrFail($id);

        if ($item->user_id !== Auth::id()) {
            return redirect()->route('items.index')->with('error', 'Unauthorized action.');
        }

        // Delete associated uploaded images from storage
        $imagePaths = is_string($item->images) ? json_decode($item->images, true) : ($item->images ?? []);
        foreach ($imagePaths as $image) {
            Storage::disk('public')->delete($image);
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', '🗑️ Item report deleted successfully!');
    }
}