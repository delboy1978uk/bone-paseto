<?php

namespace Bone\Test\Paseto;

use Barnacle\Container;
use Barnacle\Exception\NotFoundException;
use Bone\Paseto\PasetoPackage;
use Bone\Paseto\PasetoService;
use Codeception\Test\Unit;

class PasetoServiceTest extends Unit
{
    public function testEncryptAndDecrypt()
    {
        $c = new Container();
        $c['bone-paseto'] = [
            'sharedKey' => 'tH1rtYtw0Ch4r4ct3rPasswordBlahXx',
        ];
        $package = new PasetoPackage();
        $package->addToContainer($c);
        /** @var PasetoService $service */
        $service = $c->get(PasetoService::class);
        $token = $service->encryptToken(['some' => 'data']);
        $this->assertIsString($token);
        $array = $service->decryptToken($token);
        $this->assertIsArray($array);
        $this->assertArrayHasKey('some', $array);
        $this->assertEquals('data', $array['some']);
    }
}
