<?php

namespace App\Http\Requests\Bunny;

class BaseResponse
{
    public bool $success;
    public string $message;
    public int $statusCode;
}
