<?php
namespace CakeTracking\Loggers;

use CakeTracking\Exceptions\CakeTrackerLoggingException;

use Cake\Core\Configure;
use Cake\Http\ServerRequestFactory;

use Psr\Http\Message\ServerRequestInterface;

/**
 * TextualLogger
 *
 * Will log all Request operations onto the Filesystem.  The destination of the
 * repository can be specified in the <em>config/app.php</em> file, otherwise
 * the default location will be under the file <em>logs/cake-tracking.log</em>.
 *
 * @author Travis Anthony Torres
 * @version September 10, 2017
 */

class TextualLogger implements TrackingLoggerInterface
{
    /**
     * Will parse the request data and write the meta information into the
     * Tracking Log.
     *
     * @param ServerRequestInterface $request
     */
    public function logRequest(ServerRequestInterface $request)
    {
        $params = $request->getServerParams();
        $ipAddress = isset($params['REMOTE_ADDR']) ? $params['REMOTE_ADDR'] : '';
        $browser = $params['HTTP_USER_AGENT'];
        $controller = $request->getParam('controller');
        $action = $request->getParam('action');
        
        $this->writeMessage(sprintf("(%s) request made to Controller '%s' action '%s' from browser '%s'",
                $ipAddress, $controller, $action, $browser));
    }
    
    /**
     * Appends the supplied message onto a text document.
     *
     * @param string $message
     *
     * @throws CakeTrackerLoggingException
     */
    public function writeMessage($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        
        //  open a file resource for the message, the name of the file will
        //  either be read from the config or the default will be used
        $textFilename = Configure::read('CakeTracking.LogFile', 'cake-tracking.txt');
        $fileResource = fopen($textFilename, 'a+');
        if ($fileResource === false) {
            throw new CakeTrackerLoggingException('cannot open file for writting');
        }
        
        //  append the message onto the log
        $bytesWritten = fwrite($fileResource, sprintf("[%s] %s\n", $timestamp, $message));
        if ($bytesWritten === false) {
            throw new CakeTrackerLoggingException('Was unable to write to cake tracking log');
        }
        
        if (!fclose($fileResource)) {
            throw new CakeTrackerLoggingException('Was unable to close log file for the cake tracking plugin');
        }
    }
}
