<?php
declare(strict_types=1);

namespace Appio\Redmine\Collection;

/**
 */
abstract class AbstractCollection implements CollectionInterface
{
    /** @var array */
    private $items;

    /** @var int */
    private $count;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
        $this->count = count($items);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->count;
    }
}
