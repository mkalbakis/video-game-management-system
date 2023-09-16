<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VideoGame;

class VideoGameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return VideoGame::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $fields = $request->validate([
            'title' => 'required|string|unique:video_games,title',
            'description' => 'required|string',
            'release_date' => 'required|date_format:d-m-Y',
            'genre' => 'required'
        ]);

        $game = VideoGame::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'release_date' => $fields['release_date'],
            'genre' => $fields['genre']
        ]);

        return response($game, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $videogame = VideoGame::find($id);

        if (!$videogame) {
            return response(['message' => 'Game Not Found'], 404);
        }

        return response($videogame, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $videogame = VideoGame::find($id);

        if (!$videogame) {
            return response(['message' => 'Game Not Found'], 404);
        }

        $request->validate([
            'title' => 'nullable|string|unique:video_games,title',
            'description' => 'nullable|string',
            'release_date' => 'nullable|date_format:d-m-Y',
            'genre' => 'nullable'
        ]);

        $videogame->update($request->all());

        return $videogame;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $videogame = VideoGame::find($id);

        if (!$videogame) {
            return response(['message' => 'Game Not Found'], 404);
        }

        VideoGame::destroy($id);

        return VideoGame::all();
    }
}
