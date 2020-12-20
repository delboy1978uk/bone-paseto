<?php

declare(strict_types=1);

namespace Bone\Paseto;

use Barnacle\Container;
use Barnacle\RegistrationInterface;

class PasetoPackage implements RegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        $c[PasetoService::class] = $c->factory(function () {
            return new PasetoService();
        });
    }
}
