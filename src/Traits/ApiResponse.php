<?php

namespace Pyjhyssc\Traits;


use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as FoundationResponse;

trait ApiResponse
{
    public function message($message, $status = "success", $data = [])
    {
        return $this->status($status, $data, FoundationResponse::HTTP_OK, $message);
    }

    protected function status($status, array $data, $code = FoundationResponse::HTTP_OK, $message = '')
    {
        $res = [
            'status' => $status,
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];

        return $this->respond($res);
    }

    protected function respond($data)
    {
        return Response::json($data, FoundationResponse::HTTP_OK);
    }

    public function success($data, $status = "success", $message = '')
    {
        return $this->status($status, $data, FoundationResponse::HTTP_OK, $message);
    }

    public function failed($message, $code = FoundationResponse::HTTP_BAD_REQUEST, $status = 'error', $data = [])
    {
        return $this->status($status, $data, $code, $message);
    }


}