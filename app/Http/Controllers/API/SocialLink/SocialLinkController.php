<?php

namespace App\Http\Controllers\API\SocialLink;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\SocialLinkService;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    protected $service;
    
    public function __construct(SocialLinkService $service) 
    {
        $this->service = $service;
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
            $result = $this->service->show($request->user_id);

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
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->service->create($request->all());

            return SendResponse::success($result, __('message.create_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th->getCode(), $th);
        }
    }

}
