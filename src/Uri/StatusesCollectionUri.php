<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Status;
use Appio\Redmine\Normalizer\Entity\StatusNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class StatusesCollectionUri extends Uri implements CollectionUriInterface
{
    const COLLECTION_KEY = 'issue_statuses';

    /**
     * @var StatusNormalizer
     */
    private $denormalizer;

    /**
     * @param StatusNormalizer $denormalizer
     * @param array $params
     */
    public function __construct(StatusNormalizer $denormalizer, array $params = [])
    {
        parent::__construct(Status::class, 'issue_statuses.json', $params);
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
