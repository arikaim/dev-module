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

/**
* Copy html component action
*/
class CopyHtmlComponent extends DevAction 
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

        $sourceName = $this->getOption('source_name',null);
        if (empty($sourceName) == true) {
            $this->error("Missing source component name");
            return false;
        }

        $destinationName = $this->getOption('destination_name',null);
        if (empty($destinationName) == true) {
            $this->error("Missing destination component name");
            return false;
        }

        $replaceFiles = $this->getOption('replace_files',false);

        // create comp
        $sourceComponent = $arikaim->get('view')->createComponent($sourceName,'en','arikaim');
        $sourcePath = $sourceComponent->getFullpath();
        $this->result('source_path',$sourcePath);

        $destComponent = $arikaim->get('view')->createComponent($destinationName,'en','arikaim');
        $destPath = $destComponent->getFullpath();
        $this->result('dest_path',$destPath);

        $result = File::copy($sourcePath,$destPath,$replaceFiles);
        if ($result !== true) {
            $this->error('Error copy component files!');
        }
     
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
