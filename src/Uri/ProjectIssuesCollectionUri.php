<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Issue;
use Appio\Redmine\Normalizer\Entity\IssueNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class ProjectIssuesCollectionUri extends PaginatedCollectionUri
{
    const COLLECTION_KEY = 'issues';

    /** @var int */
    private $projectId;

    /** @var IssueNormalizer */
    private $denormalizer;

    /**
     * @param int $projectId
     * @param IssueNormalizer $denormalizer
     * @param int $limit
     * @param int $offset
     * @param array $params
     */
    public function __construct(
        int $projectId,
        IssueNormalizer $denormalizer,
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET,
        array $params = []
    ) {
        $this->projectId = $projectId;
        parent::__construct(Issue::class, 'issues.json', $limit, $offset, $params);
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
    public function create(int $limit = self::DEFAULT_LIMIT, int $offset = self::DEFAULT_OFFSET): CollectionUriInterface
    {
        return new self($this->projectId, $this->denormalizer, $limit, $offset, $this->getParams());
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
    protected function getDefaultParams(): array
    {
        return array_merge(parent::getDefaultParams(), ['project_id' => $this->projectId]);
    }
}
