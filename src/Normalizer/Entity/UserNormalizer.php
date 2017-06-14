<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\User;
use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class UserNormalizer implements DenormalizerInterface
{
    const KEY = 'user';

    use DenormalizerTrait;

    /**
     * {@inheritdoc}
     * @return User
     * @throws EntityNotFoundException
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): User
    {
        return User::createFromArray($this->getObjectData($data, self::KEY));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === User::class && $format === 'json';
    }
}
