<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Priority;
use Appio\Redmine\Normalizer\Entity\PriorityNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class PrioritiesCollectionUri extends Uri implements CollectionUriInterface
{
    const COLLECTION_KEY = 'issue_priorities';

    /** @var PriorityNormalizer */
    private $denormalizer;

    /**
     * @param PriorityNormalizer $denormalizer
     * @param array $params
     */
    public function __construct(PriorityNormalizer $denormalizer, array $params = [])
    {
        parent::__construct(Priority::class, 'enumerations/issue_priorities.json', $params);
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
