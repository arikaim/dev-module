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
}
