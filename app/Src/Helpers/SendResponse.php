<?php
namespace App\Src\Helpers;

use App\Src\Exceptions\ClientException;
use App\Src\Exceptions\ServerException;
use App\Src\Exceptions\ValidatorException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class SendResponse
{
	
    /**
     * Send the success response.
     * 
     * @param array $result
     * @param string $message
     * @param string $redirectPath
     * @param integer $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
	public static function success($result = [], $message = 'Well done!', $redirectPath = '', $code = 200)
	{
		$response = [
            'code' => $code,
            'status' => 'success',
            'message' => $message,
            'data' => $result,
        ];

		return request()->wantsJson()
                    ? new JsonResponse($response, $code)
                    : redirect()->intended($redirectPath)->withInput()->with($response);
	}

    /**
     * Send the error response.
     * 
     * @param array $result
     * @param string $message
     * @param string $redirectPath
     * @param Throwable $th
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
	public static function error($result = [], $message = 'Something went wrong!', $redirectPath = '', Throwable $th = null)
	{
        $code = $th ? ($th->getCode() > 505 || $th->getCode() == 0 ? 500 : $th->getCode()) : 500;

        if ($th instanceof ValidationException) {
            $result = $th->errors();
            $code = $th->status;
        }

		$response = [
            'code' => $code,
            'status' => 'error',
            'message' => $message,
            'errors' => $result,
        ];

        if (!$redirectPath && !request()->wantsJson()) {
            return abort($code, $message);
        }

		return request()->wantsJson()
                    ? new JsonResponse($response, $code)
                    : redirect()->intended($redirectPath)->withInput()->withErrors($response);
	}

}
