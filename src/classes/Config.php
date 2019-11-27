<?php

namespace Classes;

use Classes\Controller;

/**
 * Initial configuration class
 * @todo Check controller class namespace path
 * @author Paul Allsopp <paul.allsopp@digital-pig.com>
 */
class Config extends Controller
{
    public function getBaseConfig($app)
    {
        parent::init($app);
        
    }
}

