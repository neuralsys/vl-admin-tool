<?php

namespace Vuongdq\VLAdminTool\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Vuongdq\VLAdminTool\Utils\ResponseUtil;

class APIRequest extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $errors)
    {
        $messages = implode(' ', Arr::flatten($errors));

        return response()->json(ResponseUtil::makeError($messages), 400);
    }
}
