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
* Create service class
*/
class CreateService extends DevAction 
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

        $serviceClass = $this->getOption('class',null);
        if (empty($serviceClass) == true) {
            $this->error("Missing service class name");
            return false;
        }
        
        $serviceName = $this->getOption('name',null);
        if (empty($serviceName) == true) {
            $this->error("Missing service name");
            return false;
        }

        $extension = $this->getOption('extension',null);
        if (empty($extension) == true) {
            $this->error("Missing extension name");
            return false;
        }
    
        $namespace = 'Arikaim\\Extensions\\' . \ucfirst($extension) . '\\Service';
        $path = Path::getExtensionPath($extension) . 'service' . DIRECTORY_SEPARATOR;
       
        // create path
        if (File::exists($path) == false) {
            File::makeDir($path);
        }

        // create action class file
        Dev::createFile($path . $serviceClass . '.php','classes/service.html',[
            'namespace' => $namespace,
            'class'     => $serviceClass,
            'name'      => $serviceName
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
