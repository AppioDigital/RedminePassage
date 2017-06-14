<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class CustomField implements CustomFieldInterface
{
    const ID_KEY = 'id';

    const NAME_KEY = 'name';

    const VALUE_KEY = 'value';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    /**
     * @param int $id
     * @param string $name
     * @param string $value
     */
    public function __construct(int $id, string $name, string $value)
    {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @param array $data
     * @return CustomField
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data): CustomField
    {
        CheckAttributeKeyUtil::checkKeys($data, [self::ID_KEY, self::NAME_KEY, self::VALUE_KEY]);
        return new self($data[self::ID_KEY], $data[self::NAME_KEY], $data[self::VALUE_KEY]);
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
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            self::ID_KEY => $this->id,
            self::NAME_KEY => $this->name,
            self::VALUE_KEY => $this->value,
        ];
    }
}
