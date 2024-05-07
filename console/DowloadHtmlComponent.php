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
use Arikaim\Core\Utils\File;

/**
 * Dowload html template component command
 */
class DowloadHtmlComponent extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('component:download');
        $this->setDescription('Download template html component');    
        $this->addOptionalArgument('template','Destination template name');     
        $this->addOptionalArgument('name','Package name');         
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
            $name = $this->question('Package name: ');
        }

        $repository = $arikaim->get('packages')->create('components')->getRepository($name);
           
        $result = $repository->download();
        if ($result == false) {
            $this->showError('Error download package');
            return;
        }
        
        $package = $arikaim->get('packages')->create('components')->createPackage($name,false);
        $destinationPath = $package->getPath();

        $result = $repository->extractPackage($destinationPath,null,function($file) use($destinationPath) {
            $this->writeLn('Extract file: ' . $file);
            if (File::exists($destinationPath . $file) == true) {
                $confirm = $this->confirmation("File exist! Replace ? ",false);
                return ($confirm == 'y') ? true : false;
            }
        });
  
        if ($result == false) {
            $this->showError('Error download componnet');
            return;  
        }

        $this->ShowCompleted();
    }
}
