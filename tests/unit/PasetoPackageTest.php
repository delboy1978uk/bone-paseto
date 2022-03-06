<?php

namespace Bone\Test\Paseto;

use Barnacle\Container;
use Barnacle\Exception\NotFoundException;
use Bone\Paseto\PasetoPackage;
use Bone\Paseto\PasetoService;

class PasetoPackageTest extends \Codeception\Test\Unit
{
    public function testPackageThrowsNotFoundException()
    {
        $c = new Container();
        $package = new PasetoPackage();
        $this->expectException(NotFoundException::class);
        $package->addToContainer($c);
    }

    public function testPackage()
    {
        $c = new Container();
        $c['bone-paseto'] = [
            'sharedKey' => 'tH1rtYtw0Ch4r4ct3rPasswordBlahXx',
        ];
        $package = new PasetoPackage();
        $package->addToContainer($c);
        $this->assertInstanceOf(PasetoService::class, $c->get(PasetoService::class));
    }
}
