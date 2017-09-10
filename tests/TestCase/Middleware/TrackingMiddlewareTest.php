<?php
namespace CakeTracking\Test\TestCase\Middleware;

use CakeTracking\Middleware\TrackingMiddleware;

use Cake\TestSuite\TestCase;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TrackingMiddlewareTest extends TestCase
{
    protected $middleware;
    protected $request;
    protected $response;
    
    /**
     * Creates a new TrackingMiddleware mock object for each test performed.
     *
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->middleware = new TrackingMiddleware();
        $this->request = $this->createMock(ServerRequestInterface::class);
        $this->response = $this->createMock(ResponseInterface::class);
    }
    
    /**
     * Ensures that the test environment is reset after each test has
     * completed.
     *
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->middleware = null;
        $this->request = null;
        $this->response = null;
    }
    
    /**
     * The middleware utility for CakePHP is still fairly new so no valid
     * interface has yet been defined for such objects.  This test will ensure
     * that the current standards are always upheld during development.
     * 
     * 1. Implements __invoke($request, $response, $next) method
     * 2. Returns a PSR-7 ResponseInterface object as a response
     *
     * More information can be found on the website below:
     * 
     * https://book.cakephp.org/3.0/en/controllers/middleware.html
     */
    public function testValidMiddleware()
    {
        if (is_callable($this->middleware)) {
            $callable = $this->middleware;
            $returnObject = $callable($this->request, $this->response, null);
            $validResponse = $returnObject instanceof ResponseInterface; 
        } else {
            $validResponse = false;
        }
        
        $this->assertTrue($validResponse);
    }
}
