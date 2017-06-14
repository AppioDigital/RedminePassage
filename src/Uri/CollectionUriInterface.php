<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

/**
 */
interface CollectionUriInterface extends UriInterface
{
    const DEFAULT_LIMIT = 100;

    const DEFAULT_OFFSET = 0;

    /**
     * @param int $limit
     * @param int $offset
     * @return CollectionUriInterface
     */
    public function create(
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET
    ): CollectionUriInterface;

    /**
     * @return string
     */
    public function getCollectionKey(): string;
}
