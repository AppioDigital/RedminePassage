<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Project;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class ProjectCollectionUri extends PaginatedCollectionUri
{
    const COLLECTION_KEY = 'projects';

    /** @var ProjectNormalizer */
    private $denormalizer;

    /**
     * @param ProjectNormalizer $denormalizer
     * @param int|null $limit
     * @param int|null $offset
     * @param array $params
     */
    public function __construct(
        ProjectNormalizer $denormalizer,
        ?int $limit = self::DEFAULT_LIMIT,
        ?int $offset = self::DEFAULT_OFFSET,
        array $params = []
    ) {
        parent::__construct(Project::class, 'projects.json', $limit, $offset, $params);
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function create(int $limit = self::DEFAULT_LIMIT, int $offset = self::DEFAULT_OFFSET): CollectionUriInterface
    {
        return new self($this->denormalizer, $limit, $offset, $this->getParams());
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
}
