<?php declare(strict_types=1);

namespace Bone\Paseto;

use DateInterval;
use DateTime;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\JsonToken;
use ParagonIE\Paseto\Keys\SymmetricKey;
use ParagonIE\Paseto\Protocol\Version2;
use ParagonIE\Paseto\Purpose;

class PasetoService
{
    /** @var string $sharedKey */
    private $sharedKey;

    /**
     * PasetoService constructor.
     * @param SymmetricKey $sharedKey
     */
    public function __construct(SymmetricKey $sharedKey)
    {
        $this->sharedKey = $sharedKey;
    }

    /**
     * @param SymmetricKey $key
     */
    public function setSharedKey(SymmetricKey $key): void
    {
        $this->sharedKey = $key;
    }

    /**
     * @param array $data
     * @param string $duration
     * @return Builder
     * @throws \ParagonIE\Paseto\Exception\InvalidKeyException
     * @throws \ParagonIE\Paseto\Exception\InvalidPurposeException
     * @throws \ParagonIE\Paseto\Exception\PasetoException
     */
    public function encryptToken(array $data, string $duration = 'P01D')
    {
        $token = (new Builder())
            ->setKey($this->sharedKey)
            ->setVersion(new Version2())
            ->setPurpose(Purpose::local())
            ->setExpiration((new DateTime())->add(new DateInterval($duration)))
            ->setClaims($data);

        return $token->toString();
    }

    /**
     * @param $providedToken
     * @return JsonToken
     * @throws \ParagonIE\Paseto\Exception\InvalidPurposeException
     */
    public function decryptToken($providedToken): JsonToken
    {
        $parser = (new Parser())
            ->setKey($this->sharedKey)
            ->addRule(new NotExpired)
            ->addRule(new IssuedBy('issuer defined during creation'))
            ->setPurpose(Purpose::local())
            ->setAllowedVersions(ProtocolCollection::v2());
        $token = $parser->parse($providedToken);

        return $token;
    }
}