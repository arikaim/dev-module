<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Modules\Dev;

use Arikaim\Core\Extension\Module;

/**
 * Dev tools module class
 */
class Dev extends Module
{   
    /**
     * Install module
     *
     * @return void
     */
    public function install()
    {    
        $this->registerConsoleCommand('JwtTokenInfoCommand');
    }
}
