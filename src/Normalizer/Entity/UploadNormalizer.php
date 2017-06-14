<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Upload;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 */
class UploadNormalizer implements NormalizerInterface, DenormalizerInterface
{
    const KEY = 'upload';

    use DenormalizerTrait;

    /**
     * {@inheritdoc}
     * @param Upload $object
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
        return $data instanceof Upload && $format === 'json';
    }

    /**
     * {@inheritdoc}
     * @return Upload
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Upload
    {
        return Upload::createFromArray($this->getObjectData($data, self::KEY));
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type instanceof Upload && $format === 'json';
    }
}
