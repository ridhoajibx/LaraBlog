<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function searchPost($param)
    {
        $posts = Post::where('title', 'like', "%".$param."%")->get();
        $response = [
            'message' => 'Post list',
            'data' => $posts
        ];
        
        try {
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Failed' . $e->errorInfo
            ]);
        }
    }
}
