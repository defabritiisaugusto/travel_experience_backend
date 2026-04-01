<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelPostRequest;
use App\Http\Resources\TravelPostsResource;
use App\Models\TravelPost;
use Illuminate\Http\Request;

class TravelPostsController extends Controller
{

    public function index() {
        return TravelPostsResource::collection(TravelPost::paginjate(10));
    }


    public function show(TravelPost $travel_post)
    {
        return new TravelPostsResource($travel_post);
    }

    

    public function store(StoreTravelPostRequest $request) 
    {
        $data = $request->validated();

        $travel_post = TravelPost::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Travel post created successfully',
            'data' => new TravelPostsResource($travel_post->fresh())
        ]);
    }

    public function update(StoreTravelPostRequest $request, TravelPost $travel_post)
    {
        $data = $request->validated();

        $travel_post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Travel post updated successfully',
            'data' => new TravelPostsResource($travel_post->fresh())
        ]);
    }

    public function destroy(TravelPost $travel_post)
    {
        $travel_post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Travel post deleted successfully',
        ]);
    }
}
