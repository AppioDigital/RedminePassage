<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

/**
 */
class AdditionalCosts implements CustomFieldInterface
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
     * @return int
     */
    public function getId(): int
    {
        return $this->customField->getId();
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
     * @param bool $value
     * @return AdditionalCosts
     */
    public static function create(bool $value): AdditionalCosts
    {
        if ($value) {
            $field = new CustomField(
                Issue::ADDITIONAL_COSTS_ID,
                Issue::ADDITIONAL_COST_NAME,
                Issue::ADDITIONAL_COSTS_TRUE_VALUE
            );
        } else {
            $field = new CustomField(
                Issue::ADDITIONAL_COSTS_ID,
                Issue::ADDITIONAL_COST_NAME,
                Issue::ADDITIONAL_COSTS_FALSE_VALUE
            );
        }

        return new self($field);
    }
}
