<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function vote(Request $request, $idea_id)
    {
        $request->validate([
            'vote_type' => 'required|in:up,down',
        ]);

        $idea = Idea::findOrFail($idea_id);

        $userVote = $idea->votes()->where('user_id', auth()->id())->first();

        if ($userVote) {
            if ($userVote->vote_type === $request->vote_type) {
                $userVote->delete();
                return redirect()->back()->with('success', 'Your vote has been removed');
            } else {
                $userVote->update(['vote_type' => $request->vote_type]);
                return redirect()->back()->with('success', 'Your vote has been changed');
            }
        }

        Vote::create([
            'idea_id' => $idea_id,
            'user_id' => auth()->id(),
            'vote_type' => $request->vote_type,
        ]);

        return redirect()->back()->with('success', 'Vote casted successfully');
    }

}
