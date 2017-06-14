<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\CustomField;
use Appio\Redmine\Entity\CustomFieldInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 */
class CustomFieldNormalizer implements DenormalizerInterface, NormalizerInterface
{
    /**
     * {@inheritdoc}
     * @return CustomField
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): CustomField
    {
        return CustomField::createFromArray($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === CustomField::class && $format === 'json';
    }

    /**
     * {@inheritdoc}
     * @param CustomFieldInterface $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        return $object->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof CustomFieldInterface && $format === 'json';
    }
}
