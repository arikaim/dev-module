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
 * Create action controller class command
 */
class CreateAction extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:action:create');
        $this->setDescription('Create action in extension');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('class','Action class');       
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
        if (empty($name) == true) {
            $class = $this->question('Action class name (no spaces):');
        }

        $extensionPath = Path::getExtensionPath($extension);
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
            return;
        }

        $action = Actions::createFromModule('CreateAction','dev',[
            'class'     => $class,           
            'extension' => $extension
        ])->getAction();
       
        $action->run();

        $this->showCompleted();
    }
}
