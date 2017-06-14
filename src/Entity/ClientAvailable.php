<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

/**
 */
class ClientAvailable implements CustomFieldInterface
{
    /** @var CustomField */
    private $customField;

    /**
     * @param CustomField $customField
     */
    public function __construct(CustomField $customField)
    {
        $this->customField = $customField;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $value = $this->getValue();

        return $value === true ? 'ANO' : 'NE';
    }

    /**
     * @return bool
     */
    public function getValue(): bool
    {
        return (bool) $this->customField->getValue();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->customField->getName();
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->customField->toArray();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->customField->getId();
    }

    /**
     * @param bool $value
     * @return ClientAvailable
     */
    public static function create(bool $value): ClientAvailable
    {
        if ($value) {
            $field = new CustomField(
                Issue::CLIENT_AVAILABLE_ID,
                Issue::CLIENT_AVAILABLE_NAME,
                Issue::CLIENT_AVAILABLE_TRUE_VALUE
            );
        } else {
            $field = new CustomField(
                Issue::CLIENT_AVAILABLE_ID,
                Issue::CLIENT_AVAILABLE_NAME,
                Issue::CLIENT_AVAILABLE_FALSE_VALUE
            );
        }

        return new self($field);
    }
}
