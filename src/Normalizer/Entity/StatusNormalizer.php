<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Status;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Appio\Redmine\Exception\EntityNotFoundException;

/**
 */
class StatusNormalizer implements DenormalizerInterface
{
    const KEY = 'status';

    use DenormalizerTrait;

    /**
     * {@inheritdoc}
     * @return Status
     * @throws \InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Status
    {
        return Status::createFromArray($this->getObjectData($data, self::KEY));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Status::class && $format === 'json';
    }
}
