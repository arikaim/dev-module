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
use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Path;
use Exception;

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
        $this->registerConsoleCommand('CreateExtension');
        $this->registerConsoleCommand('CreateController');
        $this->registerConsoleCommand('CreateDriver');
        $this->registerConsoleCommand('CreateAction');
        $this->registerConsoleCommand('CreateDbModel');
    }

    /**
     * Create file
     *
     * @param string $fileName
     * @param string $templateName
     * @param array  $params
     * @return boolean
     */
    public static function createFile(string $fileName, string $templateName, array $params = []): bool
    {
        global $arikaim;

        $path = Path::getModulePath('dev') . 'templates' . DIRECTORY_SEPARATOR;
        if (File::exists($path . $templateName) == false) {
            throw new Exception("Module template file not exist", 1);
        }

        $templateCode = File::read($path . $templateName);
        $code = $arikaim->get('view')->fetchFromString($templateCode,$params);
        
        return (File::exists($fileName) == false) ? File::write($fileName,$code) : true;
    }
}
