<?php
declare(strict_types=1);

namespace Appio\Redmine\Collection;

/**
 */
interface PaginatedCollectionInterface extends CollectionInterface
{
    const LIMIT = 'limit';

    const OFFSET = 'offset';

    /**
     * @return bool
     */
    public function isFirstPage(): bool;
}
