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
            // $request->merge(['user_id' => $request->user()->id]);    // Uncomment this
            $data = array_merge(['user_id' => $request->user()->id], $request->all());
            $result = $this->service->create($data);

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
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->service->update($request->all());

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
     * Change the user password.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function changePassword(Request $request)
    {
        try {
            $user = $request->user();
            $request->merge(['user_id' => $user->id, "user_password" => $user->password]);
            $result = $this->service->changePassword($request->all());

            return SendResponse::success($result, __('message.change_password_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

}
