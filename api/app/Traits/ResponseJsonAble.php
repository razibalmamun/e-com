<?php

namespace App\Traits;

use Illuminate\Http\Response as Res;
use Response;

trait ResponseJsonAble
{
    protected $statusCode = Res::HTTP_OK;
    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
    /**
     * @param $message
     * @return json response
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }
    public function respondCreated($message, $data = null)
    {
        return $this->respond([
            'status' => 1,
            'status_code' => $this->getStatusCode(),
            'message' => $message,
            'data' => $data
        ]);
    }

    public function respondUpdated($message, $data = null)
    {
        return $this->respond([
            'status' => 1,
            'status_code' => $this->getStatusCode(),
            'message' => $message,
            'data' => $data
        ]);
    }

    public function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(Res::HTTP_NOT_FOUND)->respond([
            'status' => 0,
            'status_code' => Res::HTTP_NOT_FOUND,
            'message' => $message,
        ]);
    }
    public function respondInternalError($message)
    {
        return $this->setStatusCode(Res::HTTP_INTERNAL_SERVER_ERROR)->respond([
            'status' => 'error',
            'status_code' => $this->getStatusCode(),
            'message' => $message,
        ]);
    }
    public function respondValidationError($message, $errors = [])
    {
        return $this->setStatusCode(Res::HTTP_UNPROCESSABLE_ENTITY)->respond([
            'status' => 0,
            'status_code' => $this->getStatusCode(),
            'message' => $message,
            'data' => $errors
        ]);
    }
    public function respondWithUnauthorisedError($message)
    {
        return $this->setStatusCode(Res::HTTP_UNAUTHORIZED)->respond([
            'status' => 'error',
            'status_code' => $this->getStatusCode(),
            'message' => $message,
        ]);
    }

    public function respondWithExpectationFailed($message)
    {
        return $this->setStatusCode(Res::HTTP_EXPECTATION_FAILED)->respond([
            'status' => 0,
            'status_code' => $this->getStatusCode(),
            'message' => $message,
        ]);
    }

    public function respondWithToken($token, $user, $expiration)
    {
        return $this->respond([
            'token' => $token,
            'tokenType' => 'Bearer',
            'expires_in' => $expiration,
            'user' => $user,
        ]);
    }
    public function respond($data, $headers = [])
    {
        return Response::json($data, $this->getStatusCode(), $headers);
    }
}