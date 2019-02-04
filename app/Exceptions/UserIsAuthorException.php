<?php

namespace App\Exceptions;

use Exception;

class UserIsAuthorException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('User is author');
    }
}
