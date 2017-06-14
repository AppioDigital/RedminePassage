<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Priority
{
    const ID_KEY = 'id';

    const NAME_KEY = 'name';

    const DEFAULT_KEY = 'default';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $default;

    /**
     * @param int $id
     * @param string $name
     * @param bool $default
     */
    public function __construct(int $id, string $name, bool $default = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->default = $default;
    }

    /**
     * @param array $data
     * @return Priority
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data): Priority
    {
        CheckAttributeKeyUtil::checkKeys($data, [self::ID_KEY, self::NAME_KEY]);
        if (array_key_exists(self::DEFAULT_KEY, $data) === true) {
            return new self($data[self::ID_KEY], $data[self::NAME_KEY], (bool) $data[self::DEFAULT_KEY]);
        }
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

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default === true;
    }
}
