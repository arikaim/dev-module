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
use Arikaim\Core\Utils\File;
use Arikaim\Modules\Dev\Dev;

/**
 * Create route controller class command
 */
class CreateController extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('controller:create');
        $this->setDescription('Create route controller class');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('name','Controller name');       
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

        $extension = $input->getArgument('extension');
        if (empty($extension) == true) {
            $extension = $this->question('Extension name: ');
        }

        $extensionPath = Path::EXTENSIONS_PATH . $extension . DIRECTORY_SEPARATOR;
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
        }
        
        $name = $input->getArgument('name');
        if (empty($name) == true) {
            $name = $this->question('Controller class name (no spaces):');
        }

        // extension class
        $class = \ucfirst($name);
        $fileName = $class . '.php';

        Dev::createFile($extensionPath . 'controllers' . DIRECTORY_SEPARATOR . $fileName,'classes/controller.html',[
            'class'     => $class,
            'extension' => $extension
        ]);

        $this->showCompleted();
    }
}
