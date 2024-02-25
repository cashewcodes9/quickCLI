<?php

namespace App\Exceptions;

use Exception;

/**
 * InvalidXmlException Class
 *
 * InvalidXmlException Class is an exception for invalid XML file.
 */
class InvalidXmlException extends \Exception
{
    /**
     * InvalidXmlException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(string $message = "Invalid XML file. Please validate your xml file and try again.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
