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
 * Create extension command
 */
class CreateExtension extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:create');
        $this->setDescription('Create extension');    
        $this->addOptionalArgument('name','Extension name');       
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
            $name = $this->question('Extension name: ');
        }

        $name = Utils::slug($name);
        $extensionPath = Path::EXTENSIONS_PATH . $name . DIRECTORY_SEPARATOR;
        if (File::exists($extensionPath) == false) {
            File::makeDir($extensionPath);
        }

        // extension class
        $class = \ucfirst($name);
        $fileName = $class . '.php';

        Dev::createFile($extensionPath . $fileName,'classes/extension.html',[
            'class' => $class,
            'name'  => $name
        ]);

        // package descriptor file
        Dev::createFile($extensionPath . 'arikaim-package.json','extension-package.json',[
            'class' => $class,
            'name'  => $name
        ]);

        // create folders
        File::makeDir($extensionPath . 'actions' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'console' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'controllers' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'models' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'models' . DIRECTORY_SEPARATOR . 'schema' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'subscribers' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'view' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'view' . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'jobs' . DIRECTORY_SEPARATOR);
        File::makeDir($extensionPath . 'service' . DIRECTORY_SEPARATOR);

        // package readme file
        Dev::createFile($extensionPath . 'README.md','readme.html',[
            'title' => $name . ' extension'
        ]);

        $this->showCompleted();
    }

    
}
