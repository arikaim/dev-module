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
use Arikaim\Core\Utils\Factory;
use Arikaim\Modules\Dev\Actions\DevAction;
use Arikaim\Modules\Dev\Dev;

/**
* Create event class
*/
class CreateEvent extends DevAction 
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

        $eventClass = $this->getOption('class',null);
        if (empty($eventClass) == true) {
            $this->error("Missing event class name");
            return false;
        }
        
        $eventName = $this->getOption('event_name',null);
        if (empty($eventName) == true) {
            $this->error("Missing event name");
            return false;
        }

        $extension = $this->getOption('extension',null);
        if (empty($extension) == true) {
            $this->error("Missing extension name");
            return false;
        }

        $namespace = Factory::getEventNamespace($extension);
        $path = Path::getExtensionPath($extension) . 'events' . DIRECTORY_SEPARATOR;
        // create path
        if (File::exists($path) == false) {
            File::makeDir($path);
        }

        // create event class file
        Dev::createFile($path . $eventClass . '.php','classes/event.html',[
            'namespace'  => $namespace,
            'class'      => $eventClass,
            'event_name' => $eventName
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
