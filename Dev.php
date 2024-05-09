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

use Arikaim\Core\Extension\Module;
use Arikaim\Modules\Dev\RequestLoggerMiddleware;

/**
 * Dev tools module class
 */
class Dev extends Module
{   
    /**
     * Boot module
     *
     * @return void
     */
    public function boot()
    {
        $this->addMiddlewareClass(RequestLoggerMiddleware::class);
    }

    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {    
        $this->registerConsoleCommand('JwtTokenInfoCommand');
        $this->registerConsoleCommand('CreateTemplate');
        $this->registerConsoleCommand('DowloadHtmlComponent');
        $this->registerConsoleCommand('CopyHtmlComponent');
    }
}
