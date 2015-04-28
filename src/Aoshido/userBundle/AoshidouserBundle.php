<?php

namespace Aoshido\userBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AoshidouserBundle extends Bundle {

    public function getparent() {
        return 'FOSUserBundle';
    }

}
