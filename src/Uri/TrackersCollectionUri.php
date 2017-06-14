<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Tracker;
use Appio\Redmine\Normalizer\Entity\TrackerNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class TrackersCollectionUri extends Uri implements CollectionUriInterface
{
    const COLLECTION_KEY = 'trackers';

    /** @var TrackerNormalizer */
    private $denormalizer;

    /**
     * @param TrackerNormalizer $denormalizer
     * @param array $params
     */
    public function __construct(TrackerNormalizer $denormalizer, array $params = [])
    {
        parent::__construct(Tracker::class, 'trackers.json', $params);
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionKey(): string
    {
        return self::COLLECTION_KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function getDenormalizer(): DenormalizerInterface
    {
        return $this->denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function create(int $limit = self::DEFAULT_LIMIT, int $offset = self::DEFAULT_OFFSET): CollectionUriInterface
    {
        return new self($this->denormalizer, $this->getParams());
    }
}
