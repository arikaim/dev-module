<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
 */
namespace Arikaim\Modules\Dev\Console;

use Arikaim\Core\Console\ConsoleCommand;
use Arikaim\Core\Utils\Path;
use Arikaim\Core\Utils\Utils;
use Arikaim\Core\Utils\File;
use Arikaim\Modules\Dev\Dev;

/**
 * Create module command
 */
class CreateModule extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('module:create');
        $this->setDescription('Create module');    
        $this->addOptionalArgument('name','Module name');       
    }

    /**
     * Run command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     */
    protected function executeCommand($input,$output)
    {
        global $arikaim;

        $this->showTitle();

        $name = $input->getArgument('name');
        if (empty($name) == true) {
            $name = $this->question('Module name: ');
        }

        $name = Utils::slug($name);
        $modulePath = Path::MODULES_PATH . $name . DIRECTORY_SEPARATOR;
        if (File::exists($modulePath) == false) {
            File::makeDir($modulePath);
        }

        // extension class
        $class = \ucfirst($name);
        $fileName = $class . '.php';

        Dev::createFile($modulePath . $fileName,'classes/module.html',[
            'class' => $class,
            'name'  => $name
        ]);

        // package descriptor file
        Dev::createFile($modulePath . 'arikaim-package.json','module-package.json',[
            'class' => $class,
            'name'  => $name
        ]);
        // composer file
        Dev::createFile($modulePath . 'composer.json','composer.html',[
            'name'  => $name
        ]);

        // create folders
        File::makeDir($modulePath . 'actions' . DIRECTORY_SEPARATOR);
        File::makeDir($modulePath . 'drivers' . DIRECTORY_SEPARATOR);
        File::makeDir($modulePath . 'console' . DIRECTORY_SEPARATOR);
        File::makeDir($modulePath . 'service' . DIRECTORY_SEPARATOR);

        // package readme file
        Dev::createFile($modulePath . 'README.md','readme.html',[
            'title' => $name . ' module'
        ]);

        $this->showCompleted();
    }

    
}
