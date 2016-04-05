<?php

namespace Aoshido\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AoshidoUserBundle extends Bundle {

    public function getparent() {
        return 'FOSUserBundle';
    }

}
