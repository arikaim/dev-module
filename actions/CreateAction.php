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

use Arikaim\Core\Utils\File;
use Arikaim\Core\Utils\Path;
use Arikaim\Modules\Dev\Actions\DevAction;
use Arikaim\Modules\Dev\Dev;

/**
* Create action class
*/
class CreateAction extends DevAction 
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
        global $arikaim;

        $actionClass = $this->getOption('class',null);
        if (empty($actionClass) == true) {
            $this->error("Missing action class name");
            return false;
        }
        
       

        $extension = $this->getOption('extension',null);
        $module = $this->getOption('module',null);

        if (empty($extension) == false) {
            $namespace = 'Arikaim\\Extensions\\' . \ucfirst($extension) . '\\Actions';
            $path = Path::getExtensionPath($extension) . 'actions' . DIRECTORY_SEPARATOR;
        } else {
            $namespace = 'Arikaim\\Modules\\' . \ucfirst($module) . '\\Actions';
            $path = Path::getModulePath($module) . 'actions' . DIRECTORY_SEPARATOR;
        }
        
        // create path
        if (File::exists($path) == false) {
            File::makeDir($path);
        }

        // create driver file
        Dev::createFile($path . $actionClass . '.php','classes/action.html',[
            'namespace' => $namespace,
            'class'     => $actionClass
        ]);
      
        return ($this->hasError() == false);
    }

    /**
    * Init descriptor properties 
    *
    * @return void
    */
    protected function initDescriptor(): void
    {
    }
}
