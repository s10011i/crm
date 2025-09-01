<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    /**
     * get entries 
     */
    public function index(Request $request)
    {
        $entries = Entry::with(['assignee', 'comments.user'])->get();

        return response()->json($entries);
    }

    /**
     * create a new entry
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
            'assignee_id' => 'nullable|exists:users,id',
            'status'      => 'nullable|in:pending,in_progress,closed',
            'comment'     => 'nullable|string|max:2000',
        ]);

        DB::transaction(function () use ($request, $entry, $validated) {
            if ($request->exists('assignee_id')) {
                $entry->assignee_id = $validated['assignee_id'] ?? null;
            }

            if (array_key_exists('status', $validated)) {
                $entry->status = $validated['status'];
            }

            $entry->save();

            // create a comment if provided and not empty whitespace
            $commentBody = trim((string) ($validated['comment'] ?? ''));
            if ($commentBody !== '') {
                $entry->comments()->create([
                    'body'    => $commentBody,
                    'user_id' => $request->user()->id,
                ]);
            }
        });

        $entry->load([
            'comments.user:id,name',
            'assignee:id,name',
        ]);

        return response()->json([
            'message' => 'Entry updated successfully',
            'entry'   => $entry,
        ]);
    }
}
