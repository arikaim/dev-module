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
use Arikaim\Modules\Dev\Actions\DevAction;
use Arikaim\Modules\Dev\Dev;

/**
* Create driver action
*/
class CreateDriver extends DevAction 
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

        $name = $this->getOption('name','driver.name');
        $title = $this->getOption('title','Driver title');
        $category = $this->getOption('category','Driver category');
        $description = $this->getOption('description','Driver description');

        $driverClass = $this->getOption('class',null);
        if (empty($driverClass) == true) {
            $this->error("Missing driver class name");
            return false;
        }
        
        $path = $this->getOption('path',null);
        if (empty($path) == true) {
            $this->error("Missing path");
            return false;
        }

        $extension = $this->getOption('extension',null);
        $module = $this->getOption('module',null);

        // create path
        if (File::exists($path) == false) {
            File::makeDir($path);
        }
      
        if (empty($extension) == false) {
            $namespace = 'Arikaim\\Extensions\\' . \ucfirst($extension) . '\\Drivers';
        } else {
            $namespace = 'Arikaim\\Modules\\' . \ucfirst($module) . '\\Drivers';
        }
      
        // create driver file
        Dev::createFile($path . $driverClass . '.php','classes/driver.html',[
            'namespace' => $namespace,
            'class'     => $driverClass,
            'name'      => $name,
            'title'     => $title,
            'category'  => $category,
            'description' => $description
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
