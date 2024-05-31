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
use Arikaim\Core\Actions\Actions;

/**
 * Copy html component command
 */
class CopyHtmlComponent extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('component:copy');
        $this->setDescription('Copy html component');    
        $this->addOptionalArgument('source','Component source name');     
        $this->addOptionalArgument('destination','Component destination name');         
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
 
        $sourceName = $input->getArgument('source');
        if (empty($sourceName) == true) {
            $sourceName = $this->question('Source component name: ');
        }

        $destinationName = $input->getArgument('destination');
        if (empty($destinationName) == true) {
            $destinationName = $this->question('Destination component name: ');
        }

        $confirm = $this->confirmation("Component exist! Replace ? ",false);
         
        $action = Actions::createFromModule('CopyHtmlComponent','dev')->getAction();
        $action->option('source_name',$sourceName);
        $action->option('destination_name',$destinationName);
        $action->option('replace_files',$confirm);

        $action->run();

        $this->writeFieldLn('Source path',$action->get('source_path',''));
        $this->writeFieldLn('Destination path',$action->get('dest_path',''));

        if ($action->hasError() == false) {
            $this->showCompleted();
        } else {
            $this->showError($action->getError());
        }
    }
}
