<?php

namespace Pyjhyssc\Exceptions;

use Exception;
use Pyjhyssc\Traits\ApiResponse;

class ApiRequestExcept extends Exception
{
    use ApiResponse;

    public function render()
    {
        return $this->failed($this->message, $this->code ?: 400);
    }
}
