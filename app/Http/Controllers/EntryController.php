<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;

class EntryController extends Controller
{
    /**
     * List entries with optional search
     */
    public function index(Request $request)
    {
        $entries = Entry::with(['assignee', 'comments.user'])->get();

        return response()->json($entries);
    }

    /**
     * Create a new entry
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'phone_number' => 'required|numeric',
            'complain'     => 'required|string',
        ]);
        

        $entry = Entry::create([
            'first_name'   => $validated['first_name'],
            'last_name'    => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'complain'     => $validated['complain'],
        ]);

        return response()->json([
            'message' => 'Entry created successfully',
            'entry'   => $entry
        ], 201);
    }

    // update
    public function update(Request $request, Entry $entry)
    {
        $validated = $request->validate([
            'assignee_id' => 'nullable|exists:users,id', // assign operator
            'status'      => 'nullable|in:pending,in_progress,closed',
        ]);

        if (isset($validated['assignee_id'])) {
            $entry->assignee_id = $validated['assignee_id'];
        }

        if (isset($validated['status'])) {
            $entry->status = $validated['status'];
        }

        $entry->save();

        return response()->json([
            'message' => 'Entry updated successfully',
            'entry'   => $entry
        ]);
    }

}
