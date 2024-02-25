<?php

namespace App\Exceptions;

use Exception;

/**
 * InvalidDatabaseException Class
 *
 * InvalidDatabaseException Class is an exception for invalid database type.
 */
class InvalidDatabaseException extends Exception
{
    /**
         * InvalidDatabaseException constructor.
         *
         * @param string $message
         * @param int $code
         * @param Exception|null $previous
         */
       public function __construct(string $message = "Invalid database type. Please use --db option to specify a valid database type.", $code = 0, Exception $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }
}
