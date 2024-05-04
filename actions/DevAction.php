<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Dev\Actions;

use Arikaim\Core\Actions\Action;
use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Path;
use Exception;

/**
* Create template action
*/
class DevAction extends Action 
{
    /**
     * Init action
     *
     * @return void
    */
    public function init(): void
    {
    }

    /**
     * Run action
     *
     * @param mixed ...$params
     * @return bool
     */
    public function run(...$params)
    {
    }

    /**
     * Create template folder
     *
     * @param string $path
     * @param string $templatePath
     * @return boolean
     */
    protected function createTemplateFolder(string $path, string $templatePath): bool
    {
        if (File::exists($templatePath . $path . DIRECTORY_SEPARATOR) == false) {
            return File::makeDir($templatePath . $path . DIRECTORY_SEPARATOR);
        }
        return true;
    }

    /**
     * Create file
     *
     * @param string $fileName
     * @param string $templateName
     * @param array  $params
     * @return boolean
     */
    protected function createFile(string $fileName, string $templateName, array $params = []): bool
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
