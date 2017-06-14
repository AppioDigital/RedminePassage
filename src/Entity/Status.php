<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Status
{
    const ID_KEY = 'id';

    const NAME_KEY = 'name';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param array $data
     * @return Status
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data): Status
    {
        CheckAttributeKeyUtil::checkKeys($data, [self::ID_KEY, self::NAME_KEY]);
        return new self($data[self::ID_KEY], $data[self::NAME_KEY]);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
