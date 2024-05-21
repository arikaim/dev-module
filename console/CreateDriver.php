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
use Arikaim\Core\Actions\Actions;

/**
 * Create driver controller class command
 */
class CreateDriver extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:driver:create');
        $this->setDescription('Create driver in extension');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('class','Driver class');       
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
            $class = $this->question('Driver class name (no spaces):');
        }

        $extensionPath = Path::EXTENSIONS_PATH . $extension . DIRECTORY_SEPARATOR;
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
            return;
        }

        $path = $extensionPath . 'drivers' . DIRECTORY_SEPARATOR;

        $action = Actions::createFromModule('CreateDriver','dev',[
            'class'     => $class,
            'path'      => $path,
            'extension' => $extension
        ])->getAction();
       
        $action->run();

        $this->showCompleted();
    }
}
