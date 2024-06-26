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
use Arikaim\Core\Utils\Utils;
use Arikaim\Core\Utils\Path;
use Arikaim\Modules\Dev\Actions\DevAction;
use Arikaim\Modules\Dev\Dev;

/**
* Create template action
*/
class CreateTemplate extends DevAction 
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

        $templateName = $this->getOption('name',null);
        if (empty($templateName) == true) {
            $this->error("Missing template name");
            return false;
        }
        
        $templateName = Utils::slug(\trim($templateName));
        $templatePath = Path::TEMPLATES_PATH . $templateName . DIRECTORY_SEPARATOR;

        // create template path
        if (File::exists($templatePath) == false) {
            File::makeDir($templatePath);
        }
        // create componens folder
        $this->createTemplateFolder('components',$templatePath);
        // create pages folder
        $this->createTemplateFolder('pages',$templatePath);
        // create css folder
        $this->createTemplateFolder('css',$templatePath);
        // create emails folder
        $this->createTemplateFolder('emails',$templatePath);
        // create images folder
        $this->createTemplateFolder('images',$templatePath);
        // create themes folder
        $this->createTemplateFolder('themes',$templatePath);
        // create files
        // .gitignore
        Dev::createFile($templatePath . '.gitignore','gitignore.html');
        // default theme
        Dev::createFile($templatePath . 'themes' . DIRECTORY_SEPARATOR . 'default.json','themes/default.html');
        // css files
        Dev::createFile($templatePath . 'css' . DIRECTORY_SEPARATOR . 'preflight.css','css/preflight.css');
        Dev::createFile($templatePath . 'css' . DIRECTORY_SEPARATOR . 'include.css','css/include.css');
        Dev::createFile($templatePath . 'css' . DIRECTORY_SEPARATOR . 'style.css','css/style.css');
        // package descriptor file
        Dev::createFile($templatePath . 'arikaim-package.json','template-package.json',[
            'name' => $templateName
        ]);
        // create taillwind config file
        Dev::createFile($templatePath . 'tailwind.config.js','tailwind.config.html');
        // template readme file
        Dev::createFile($templatePath . 'README.md','template-readme.html',[
            'name' => $templateName
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
