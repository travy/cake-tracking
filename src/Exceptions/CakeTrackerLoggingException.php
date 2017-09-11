<?php
namespace CakeTracking\Exceptions;

use Cake\Core\Exception\Exception;

/**
 * CakeTrackerLoggingException
 *
 * Exception which specified that an operation failed while attempting to Log
 * a Request entry.
 *
 * @author Travis Anthony Torres
 * @version September 10, 2017
 */

class CakeTrackerLoggingException extends Exception
{
    /**
     * Describes the cause of the Exception during the logging operation.
     *
     * @param string $message
     * @param mixed $code
     * @param mixed $previous
     */
    public function __construct($message, $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
