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

use Lcobucci\JWT\Configuration;

use Arikaim\Core\Console\ConsoleCommand;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Hmac\Sha256;

/**
 * Jwt token info command
 */
class JwtTokenInfoCommand extends ConsoleCommand
{  
    /**
     * Configure command
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('jwt:info');
        $this->setDescription('Decode jwt token and show info');    
        $this->addOptionalArgument('token','Jwt Token');       
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

        $token = $input->getArgument('token');
        if (empty($token) == true) {
            $token = $this->question('Jwt Token:');
        }

        $key = $arikaim->get('config')['settings']['jwtKey'] ?? '';
        $this->writeFieldLn('Key ',$key);

        $config = Configuration::forSymmetricSigner(new Sha256(),InMemory::plainText($key));
        $token = $config->parser()->parse($token);

        if (\is_object($token) == false) {
            $this->showError('Error parse jwt token.');
            exit();
        } 

        $this->writeLn('Headers');
        foreach ($token->headers()->all() as $key => $value) {
            if (is_object($value) == true) {              
                $this->writeLn($key);
                print_r($value);
            } else {
                $this->writeFieldLn($key,$value);
            }
        }
       
        $this->writeLn('Claims');
        foreach ($token->claims()->all() as $key => $value) {
            if (is_object($value) == true) {              
                $this->writeLn($key);
                print_r($value);
            } else {
                $this->writeFieldLn($key,$value);
            }
        }
    }
}
