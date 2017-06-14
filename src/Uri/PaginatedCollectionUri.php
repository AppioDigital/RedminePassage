<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

/**
 */
abstract class PaginatedCollectionUri extends Uri implements PaginatedCollectionUriInterface
{
    /**
     * @var int
     */
    private $limit;

    /**
     * @var int
     */
    private $offset;

    /**
     * @param string $class
     * @param string $uri
     * @param int|null $limit
     * @param int|null $offset
     * @param array $params
     */
    public function __construct(
        string $class,
        string $uri,
        ?int $limit = self::DEFAULT_LIMIT,
        ?int $offset = self::DEFAULT_OFFSET,
        array $params = []
    ) {
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
        $this->offset = $offset ?? self::DEFAULT_OFFSET;

        parent::__construct($class, $uri, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return array
     */
    protected function getDefaultParams(): array
    {
        return array_merge(parent::getDefaultParams(), ['limit' => $this->getLimit(), 'offset' => $this->getOffset()]);
    }
}
