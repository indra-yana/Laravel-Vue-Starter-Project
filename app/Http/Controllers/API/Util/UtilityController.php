<?php

namespace App\Http\Controllers\API\Util;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\EditorJS\EditorJSUploader;
use App\Src\Services\EditorJS\MetaFetcher;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    
    public function __construct() 
    {

    }
    
    /**
     * get meta data from any url.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function meta(Request $request) 
    {
        try {
            return MetaFetcher::fetch($request->url);
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Handle upload image by file for editor.js.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadByFile(Request $request)
    {
        try {
            return SendResponse::success(EditorJSUploader::uploadByFile($request->all()), __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Handle upload image by url for editor.js.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadByUrl(Request $request)
    {
        try {
            return SendResponse::success(EditorJSUploader::uploadByUrl($request->all()), __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

}
