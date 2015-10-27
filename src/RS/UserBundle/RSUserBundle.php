<?php

namespace RS\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RSUserBundle extends Bundle
{
        public function getParent()
    {
        return 'FOSUserBundle';
    }
        
}
