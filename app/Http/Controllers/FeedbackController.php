<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Inertia\Inertia;

class FeedbackController extends Controller
{
    public function index()
    {
        return Inertia::render('Feedback/Index', [
            'feedbacks' => Feedback::with('user')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|min:3|max:255',
        ]);

        Feedback::create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Feedback added successfully');
    }
}
