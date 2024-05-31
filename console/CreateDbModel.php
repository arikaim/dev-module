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
 * Create db model class command
 */
class CreateDbModel extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('extension:model:create');
        $this->setDescription('Create db model class in extension');    
        $this->addOptionalArgument('extension','Extension name');    
        $this->addOptionalArgument('class','Model class');       
        $this->addOptionalArgument('table_name','Db table name');       
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
            $class = $this->question('Db Model class name (no spaces):');
        }

        $tableName = $input->getArgument('table_name');
        if (empty($tableName) == true) {
            $tableName = $this->question('Db table name (no spaces):');
        }

        $extensionPath = Path::getExtensionPath($extension);
        if (File::exists($extensionPath) == false) {
            $this->showError('Extension not exist');
            return;
        }

        $action = Actions::createFromModule('CreateModel','dev',[
            'class'      => $class,           
            'table_name' => $tableName,           
            'extension'  => $extension
        ])->getAction();
       
        $action->run();
        
        if ($action->hasError() == false) {
            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
