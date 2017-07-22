<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Journal;
use Appio\Redmine\Entity\User;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class JournalNormalizer implements DenormalizerInterface
{
    const JOURNAL_KEY = 'journal';

    const USER_KEY = 'user';

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
     * @return Journal
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Journal
    {
        $objectData = $this->getObjectData($data, self::JOURNAL_KEY);
        /** @var User $user */
        $user = $this->denormalizer->denormalize($objectData[self::USER_KEY], User::class, $format, $context);
        return Journal::createFromArray($objectData, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Journal::class && $format === 'json';
    }
}
