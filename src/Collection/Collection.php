<?php
declare(strict_types=1);

namespace Appio\Redmine\Collection;

use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Uri\CollectionUriInterface;

/**
 */
class Collection extends AbstractCollection
{
    /**
     * {@inheritdoc}
     */
    public function handleAll(ObjectFetcher $fetcher, CollectionUriInterface $uri, array $options = []): array
    {
        return $this->toArray();
    }
}
