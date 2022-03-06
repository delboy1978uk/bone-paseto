<?php declare(strict_types=1);

namespace Bone\Paseto;

use Barnacle\Container;
use Barnacle\Exception\NotFoundException;
use Barnacle\RegistrationInterface;
use ParagonIE\Paseto\Keys\SymmetricKey;

class PasetoPackage implements RegistrationInterface
{
    /**
     * @param Container $c
     */
    public function addToContainer(Container $c)
    {
        if (!$c->has('bone-paseto')) {
            throw new NotFoundException('Please add a bone-paseto array config with a key `sharedKey`');
        }

        $config = $c->get('bone-paseto');
        $sharedKey = $config['sharedKey'];
        $c[SymmetricKey::class] = new SymmetricKey($sharedKey);

        $c[PasetoService::class] = $c->factory(function (Container $c) {
            $key = $c->get(SymmetricKey::class);

            return new PasetoService($key);
        });
    }
}
