<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLikeRequest;
use App\Models\Like;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request) 
    {
        $data = $request->validated();

        $like = Like::firstOrCreate($data); // Crea un like se non esiste già, altrimenti restituisce il like esistente

        return response()->json([
            'success' => true,
            'message' => 'Like created successfully',
            'data' => $like,
        ]);
    }

    public function destroy(Like $like)
    {
        $like->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like deleted successfully',
            'data' => [],
        ]);
    }
}
