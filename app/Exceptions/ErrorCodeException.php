<?php

namespace App\Exceptions;

use Exception;

class ErrorCodeException extends Exception
{
    public function errorCode() {
        //error message
        $errorMsg = $this->getLine();
        return $errorMsg;
      }
}
