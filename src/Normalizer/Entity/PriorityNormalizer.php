<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Priority;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class PriorityNormalizer implements DenormalizerInterface
{
    const KEY = 'priority';

    use DenormalizerTrait;

    /**
     * {@inheritdoc}
     * @return Priority
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Priority
    {
        return Priority::createFromArray($this->getObjectData($data, self::KEY));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Priority::class && $format === 'json';
    }
}
