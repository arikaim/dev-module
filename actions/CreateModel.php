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
use Arikaim\Core\Utils\Factory;

/**
* Create db model and schema class
*/
class CreateModel extends DevAction 
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

        $modelClass = $this->getOption('class',null);
        if (empty($modelClass) == true) {
            $this->error("Missing model class name");
            return false;
        }
        
        $extension = $this->getOption('extension',null);
        if (empty($extension) == true) {
            $this->error("Missing extension name");
            return false;
        }

        $tableName = $this->getOption('table_name',null);
        if (empty($tableName) == true) {
            $this->error("Missing db table name");
            return false;
        }

        $namespace = Factory::getExtensionModelNamespace($extension);
        $path = Path::getExtensionPath($extension) . 'models' . DIRECTORY_SEPARATOR;
      
        // create path
        if (File::exists($path) == false) {
            File::makeDir($path);
        }

        // create db model file
        Dev::createFile($path . $modelClass . '.php','classes/db-model.html',[
            'namespace'  => $namespace,
            'table_name' => $tableName,
            'class'      => $modelClass
        ]);
      
        // create db schema file
        $schemaPath = $path . 'schema' . DIRECTORY_SEPARATOR;        
        Dev::createFile($schemaPath . $modelClass . '.php','classes/db-model-schema.html',[
            'namespace'  => $namespace . '\\Schema',
            'table_name' => $tableName,
            'class'      => $modelClass
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
