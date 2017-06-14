<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Tracker;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Appio\Redmine\Exception\EntityNotFoundException;

/**
 */
class TrackerNormalizer implements DenormalizerInterface
{
    const KEY = 'tracker';

    use DenormalizerTrait;

    /**
     * {@inheritdoc}
     * @return Tracker
     * @throws \InvalidArgumentException
     * @throws EntityNotFoundException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Tracker
    {
        return Tracker::createFromArray($this->getObjectData($data, self::KEY));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Tracker::class && $format === 'json';
    }
}
