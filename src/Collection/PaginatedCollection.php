<?php
declare(strict_types=1);

namespace Appio\Redmine\Collection;

use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Uri\CollectionUriInterface;

/**
 */
class PaginatedCollection extends AbstractCollection implements PaginatedCollectionInterface
{
    /** @var int */
    private $totalCount;

    /** @var int */
    private $offset;

    /** @var int */
    private $limit;

    /**
     * @param array $items
     * @param int $totalCount
     * @param int $offset
     * @param int $limit
     */
    public function __construct(array $items, int $totalCount, int $offset, int $limit)
    {
        parent::__construct($items);
        $this->totalCount = $totalCount;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function concatenate(CollectionInterface $other): Collection
    {
        return new Collection(array_merge($this->toArray(), $other->toArray()));
    }

    /**
     * {@inheritdoc}
     */
    public function isFirstPage(): bool
    {
        return $this->offset === 0;
    }

    /**
     * {@inheritdoc}
     */
    public function handleAll(ObjectFetcher $fetcher, CollectionUriInterface $uri, array $options = []): array
    {
        if ($this->isFirstPage() === true) {
            $restUri = $uri->create($this->totalCount, $this->offset + $this->count());
            $rest = $fetcher->fetchCollection($restUri, $options);

            return $this->concatenate($rest)->toArray();
        }

        return $fetcher->fetchAll($uri->create());
    }
}
