<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Dev;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Arikaim\Core\Framework\Middleware\Middleware;
use Arikaim\Core\Framework\MiddlewareInterface;
use Arikaim\Core\Access\Provider\AuthProvider;

/**
 * Rquest logger middleware class
 */
class RequestLoggerMiddleware extends Middleware implements MiddlewareInterface
{
    /**
     * Process middleware 
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return array [$request,$response]
     */
    public function process(ServerRequestInterface $request, ResponseInterface $response): array
    {       
        global $arikaim;

        $auth = AuthProvider::readAuthHeader($request,false);
    
        $arikaim->get('logger')->info('request auth header',[
            'url'           => $request->getUri()->getPath(),
            'method'        => $request->getMethod(),
            'Authorization' => empty($auth) ? 'N/A' : $auth
        ]);

        return [$request,$response];            
    }
}
