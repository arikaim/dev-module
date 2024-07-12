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
use Arikaim\Core\Actions\Actions;

/**
 * Create service class command
 */
class CreateService extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:service:create');
        $this->setDescription('Create service in extension');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('class','Service class');       
        $this->addOptionalArgument('name','Service name');       
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
 
        $class = $input->getArgument('class');
        if (empty($class) == true) {
            $class = $this->question('Service class (no spaces):');
        }

        $name = $input->getArgument('name');
        if (empty($name) == true) {
            $name = $this->question('Service name (no spaces):');
        }

        $extensionPath = Path::getExtensionPath($extension);
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
            return;
        }

        $action = Actions::createFromModule('CreateService','dev',[
            'class'     => $class,           
            'name'      => $name,           
            'extension' => $extension
        ])->getAction();
       
        $action->run();

        if ($action->hasError() == false) {
            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
