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
 * Create event class command
 */
class CreateEvent extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:event:create');
        $this->setDescription('Create event');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('class','Event class');      
        $this->addOptionalArgument('name','Event name');       
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
            $class = $this->question('Event class name (no spaces):');
        }

        $eventName = $input->getArgument('name');
        if (empty($eventName) == true) {
            $eventName = $this->question('Event name (no spaces):');
        }

        $extensionPath = Path::getExtensionPath($extension);
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
            return;
        }

        $action = Actions::createFromModule('CreateEvent','dev',[
            'class'      => $class,           
            'extension'  => $extension,
            'event_name' => $eventName
        ])->getAction();
       
        $action->run();

        if ($action->hasError() == false) {
            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
