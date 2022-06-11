<?php

namespace App\Http\Controllers\API\Post;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $service;
    
    public function __construct(PostService $service) 
    {
        $this->service = $service;
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
            $result = $this->service->userPost($request->user()->id);

            return SendResponse::success($result, __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
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
            $result = $this->service->show($request->id);

            return SendResponse::success($result, __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
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
            $result = $this->service->detail($request->id);

            return SendResponse::success($result, __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
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
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->service->create($request->all());

            return SendResponse::success($result, __('message.create_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
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
            $result = $this->service->update($data);

            return SendResponse::success($result, __('message.update_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
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
            $result = $this->service->delete($request->id);

            return SendResponse::success($result, __('message.delete_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Get data for datatable json.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function dtTableJson(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->service->dtTableJson($request->all());

            return $result;
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

}
