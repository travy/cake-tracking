<?php
namespace CakeTracking\Loggers;

use Psr\Http\Message\ServerRequestInterface;

/**
 * TrackingLoggerInterface
 *
 * An interface used for creation of custom tracking log repositories used by
 * the Middleware subsystem.
 *
 * @author Travis Anthony Torres
 * @version September 10, 2017
 */

interface TrackingLoggerInterface
{
    /**
     * Logs each Request that is made.
     *
     * @param ServerRequestInterface $request
     */
    public function logRequest(ServerRequestInterface $request);
    
    /**
     * Records a specified message in the repository.
     *
     * @param string $message
     *
     * @throws CakeTrackingLoggerException when an error occurs
     */
    public function writeMessage($message);
}
