<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class IdeaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
        ]);

        Idea::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'submitter_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Idea added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($idea_id)
    {
        $idea = Idea::findOrFail($idea_id);
        $idea->delete();

        return redirect()->back()->with('success', 'Idea deleted successfully');
    }
}
