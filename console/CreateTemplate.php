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
use Arikaim\Core\Utils\Utils;

/**
 * Create template command
 */
class CreateTemplate extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('template:create');
        $this->setDescription('Create template');    
        $this->addOptionalArgument('name','Template name');       
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
            $name = $this->question('Template name: ');
        }
        $name = Utils::slug($name);

        $action = Actions::createFromModule('CreateTemplate','dev');
        $action->option('name',$name);
    
        $action->run();

        $this->showCompleted();
    }
}
