<?php declare(strict_types=1);

namespace Bone\Paseto;

use Barnacle\Container;
use Barnacle\Exception\NotFoundException;
use Barnacle\RegistrationInterface;
use Bone\Console\Command;
use Bone\Contracts\Container\DefaultSettingsProviderInterface;
use ParagonIE\Paseto\Keys\SymmetricKey;
use Symfony\Component\Console\Style\SymfonyStyle;

class PasetoPackage implements RegistrationInterface, DefaultSettingsProviderInterface
{
    public function addToContainer(Container $c): void
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

    public function getRequiredPackages(): array
    {
        return [];
    }

    public function getSettingsFileName(): string
    {
        return __DIR__ . '/../data/config/bone-paseto.php';
    }

    public function postInstall(Command $command, SymfonyStyle $io): void {}


}
