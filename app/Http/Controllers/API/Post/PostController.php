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
     * Get the user post list.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function userPost(Request $request)
    {
        try {
            $result = $this->postService->userPost($request->user()->id);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

    /**
     * Get the single model data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function show(Request $request)
    {
        try {
            $result = $this->postService->show($request->id);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

    /**
     * Get the single model data with detail.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function detail(Request $request)
    {
        try {
            $result = $this->postService->detail($request->id);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

    /**
     * Create a new data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function create(Request $request)
    {
        try {
            $data = array_merge(['user_id' => $request->user()->id], $request->all());
            $result = $this->postService->create($data);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

    /**
     * Update an existing data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function update(Request $request)
    {
        try {
            $data = array_merge(['user_id' => $request->user()->id], $request->all());
            $result = $this->postService->update($data);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

    /**
     * Delete an existing data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function delete(Request $request)
    {
        try {
            $result = $this->postService->delete($request->id);

            return SendResponse::success($result, __('Data retrieved successfully'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

}
