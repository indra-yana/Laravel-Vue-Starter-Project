<?php

namespace App\Http\Controllers\API\Post;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postService;
    
    public function __construct(PostService $postService) 
    {
        $this->postService = $postService;
    }

    /**
     * Get the user post list
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function getUserPost(Request $request)
    {
        try {
            $result = $this->postService->getUserPost($request->user()->id);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

}
