<?php

namespace App\Exceptions;

use Exception;

class UserIsAlreadySubscribedException extends Exception
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
