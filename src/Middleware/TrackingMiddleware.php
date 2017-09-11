<?php
namespace CakeTracking\Middleware;

use CakeTracking\Loggers\TextualLogger;
use CakeTracking\Loggers\TrackingLoggerInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * TrackingMiddleware
 *
 * CakePHP Middleware which will enable the logging of all requests made to the
 * web application.  In addition to basic logging, various operations can be
 * made to ensure site security.  Each user can be confirmed as being legit-
 * imate by matching HTTP data such as the IP address of the client and User
 * Agent with the Session that is being used to establish a connection.
 *
 * @author Travis Anthony Torres
 * @version September 10, 2017
 */

class TrackingMiddleware
{
    protected $loggingOperation;
    
    /**
     * Logs all requests made to the application along with the Controller and
     * Actions that are being requested.  The session will then be checked
     * against a blacklist (if one exists) to determine if the request should
     * actively be denied.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param mixed $next Generally a <em>MiddlewareQueue</em> object but the
     *        CakePHP documentation does not currently clarify this
     *
     * @return type
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $request = $request ?: ServerRequestFactory::fromGlobals();
        
        $logger = $this->getLoggingOperation();
        $logger->logRequest($request);
    
        
        
        return $next($request, $response);
    }
    
    /**
     * Specifies a custom log handler responsible for storing all data for
     * tracking requests.
     *
     * @param TrackingLoggerInterface $logger
     */
    public function setLoggingOperation(TrackingLoggerInterface $logger)
    {
        $this->loggingOperation = $logger;
    }
    
    /**
     * Retrieves the desired log handler for tracking requests made to the
     * application.
     *
     * @return TrackingLoggerInterface
     */
    public function getLoggingOperation()
    {
        if (is_null($this->loggingOperation)) {
            $this->setLoggingOperation(new TextualLogger());
        }
        
        return $this->loggingOperation;
    }
}
