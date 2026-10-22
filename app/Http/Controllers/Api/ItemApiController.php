<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemApiController extends Controller
{
    // 1. READ (GET): Retrieve all item records
    public function index()
    {
        $items = Item::with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Lost and found item records retrieved successfully.',
            'data' => $items
        ], 200);
    }

    // 2. CREATE (POST): Add a new item record
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error on input data.',
                'errors' => $validator->errors()
            ], 422);
        }

        $item = Item::create([
            'user_id' => $request->user_id ?? 1, // Fallback default user if testing via API without auth token
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'category' => $request->category,
            'location' => $request->location,
            'date' => $request->date,
            'full_name' => $request->full_name,
            'student_id' => $request->student_id,
            'department' => $request->department,
            'facebook_link' => $request->facebook_link,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'images' => json_encode([]),
            'status' => 'pending',
            'is_reported' => false,
            'report_count' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Item record created successfully.',
            'data' => $item
        ], 201);
    }

    // 3. READ (GET): Retrieve a single specific item record
    public function show($id)
    {
        $item = Item::with('user')->find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item record not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item record retrieved successfully.',
            'data' => $item
        ], 200);
    }

    // 4. UPDATE (PUT/PATCH): Modify an existing item record
    public function update(Request $request, $id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item record not found for update.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:lost,found',
            'category' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'date' => 'sometimes|required|date',
            'full_name' => 'sometimes|required|string|max:255',
            'student_id' => 'sometimes|required|string|max:255',
            'department' => 'sometimes|required|string|max:255',
            'contact_number' => 'sometimes|required|string|max:50',
            'email' => 'sometimes|required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error during update.',
                'errors' => $validator->errors()
            ], 422);
        }

        $item->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Item record updated successfully.',
            'data' => $item
        ], 200);
    }

    // 5. DELETE (DELETE): Remove an item record
    public function destroy($id)
    {
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Item record not found for deletion.'
            ], 404);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item record deleted successfully.'
        ], 200);
    }
}