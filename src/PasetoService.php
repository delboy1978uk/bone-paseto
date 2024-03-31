<?php declare(strict_types=1);

namespace Bone\Paseto;

use DateInterval;
use DateTime;
use ParagonIE\Paseto\Builder;
use ParagonIE\Paseto\JsonToken;
use ParagonIE\Paseto\Keys\SymmetricKey;
use ParagonIE\Paseto\Parser;
use ParagonIE\Paseto\Protocol\Version4;
use ParagonIE\Paseto\ProtocolCollection;
use ParagonIE\Paseto\Purpose;
use ParagonIE\Paseto\Rules\IssuedBy;
use ParagonIE\Paseto\Rules\NotExpired;

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
     * @param array $data
     * @param string $duration
     * @return string
     * @throws \ParagonIE\Paseto\Exception\InvalidKeyException
     * @throws \ParagonIE\Paseto\Exception\InvalidPurposeException
     * @throws \ParagonIE\Paseto\Exception\PasetoException
     */
    public function encryptToken(array $data, string $duration = 'P01D')
    {
        $token = (new Builder())
            ->setKey($this->sharedKey)
            ->setVersion(new Version4())
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
            ->addRule(new NotExpired())
            ->setPurpose(Purpose::local())
            ->setAllowedVersions(ProtocolCollection::v4());
        $token = $parser->parse($providedToken);

        return $token;
    }
}
