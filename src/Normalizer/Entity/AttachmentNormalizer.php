<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Attachment;
use Appio\Redmine\Entity\User;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class AttachmentNormalizer implements DenormalizerInterface
{
    const ATTACHMENT_KEY = 'attachment';

    const AUTHOR_KEY = 'author';

    use DenormalizerTrait;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     * @return Attachment
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Attachment
    {
        $objectData = $this->getObjectData($data, self::ATTACHMENT_KEY);
        /** @var User $author */
        $author = $this->denormalizer->denormalize($objectData[self::AUTHOR_KEY], User::class, $format, $context);
        return Attachment::createFromArray($objectData, $author);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Attachment::class && $format === 'json';
    }
}
