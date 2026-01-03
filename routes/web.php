<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\Idea;
use Inertia\Inertia;

Route::middleware("auth")->group(function () {

    Route::post("/logout", [AuthController::class, "logout"]);

    Route::middleware("role:admin,reviewer")->post("/ideas/{idea_id}/vote", [VoteController::class, "vote"]);
    Route::middleware("role:admin")->delete("/ideas/{idea_id}", [IdeaController::class, "destroy"]);

    Route::post("/ideas", [IdeaController::class, "store"]);
    Route::post("/ideas/{idea_id}/comments", [CommentController::class, "store"]);

    Route::post("/feedback", [FeedbackController::class, "store"]);
    Route::middleware("role:admin")->get("/feedback", [FeedbackController::class, "index"]);
});

Route::middleware("guest")->group(function () {
    Route::get("/login", [AuthController::class, "loginView"])->name("login");
    Route::get("/register", [AuthController::class, "registerView"])->name("register");

    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/register", [AuthController::class, "register"]);
});

Route::get('/', function () {

    return Inertia::render('Home/Index', [
        'ideas' => Inertia::scroll(
            fn() =>
            Idea::with([
                'user',
                'votes',
                'comments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                },

            ])
                ->withCount([
                    'votes as up_votes_count' => function ($query) {
                        $query->where('vote_type', 'up');
                    },
                ])
                ->orderBy('created_at', 'desc')
                ->paginate(10)
        ),
    ]);

})->name('home');
