<?php
namespace CakeTracking\Test\TestCase\Middleware;

use CakeTracking\Middleware\TrackingMiddleware;

use Cake\TestSuite\TestCase;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Cake\Http\MiddlewareQueue;

class TrackingMiddlewareTest extends TestCase
{
    protected $middleware;
    protected $request;
    protected $response;
    protected $middlewareQueue;
    
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
        
        //  mocks an invokable middleware queue which returns a response
        $this->middlewareQueue = $this->getMockBuilder(MiddlewareQueue::class)
                ->setMethods(['__invoke'])
                ->getMock();
        $this->middlewareQueue
                ->method('__invoke')
                ->willReturn($this->createMock(ResponseInterface::class));
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
            $returnObject = $callable($this->request, $this->response, $this->middlewareQueue);
            $validResponse = $returnObject instanceof ResponseInterface; 
        } else {
            $validResponse = false;
        }
        
        $this->assertTrue($validResponse);
    }
}
