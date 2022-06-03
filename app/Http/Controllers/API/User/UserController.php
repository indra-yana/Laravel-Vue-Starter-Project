<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;
    
    public function __construct(UserService $service) 
    {
        $this->service = $service;
    }

    /**
     * Get the single model data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function index(Request $request)
    {
        try {
            $result = $request->user();

            return SendResponse::success($result, __('message.retrieve_success'));
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
            $result = $this->service->show($request->id);

            return SendResponse::success($result, __('message.retrieve_success'));
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
            $result = $this->service->detail($request->id);

            return SendResponse::success($result, __('message.retrieve_success'));
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
            // $request->merge(['user_id' => $request->user()->id]);    // Uncomment this
            $data = array_merge(['user_id' => $request->user()->id], $request->all());
            $result = $this->service->create($data);

            return SendResponse::success($result, __('message.create_success'));
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
            $result = $this->service->update($data);

            return SendResponse::success($result, __('message.update_success'));
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
            $result = $this->service->delete($request->id);

            return SendResponse::success($result, __('message.delete_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

}
