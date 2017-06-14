<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

/**
 */
interface PaginatedCollectionUriInterface extends CollectionUriInterface
{
    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @return int
     */
    public function getOffset(): int;
}
