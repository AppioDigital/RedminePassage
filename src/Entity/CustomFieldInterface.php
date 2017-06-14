<?php
declare(strict_types=1);


namespace Appio\Redmine\Entity;

/**
 */
interface CustomFieldInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return array
     */
    public function toArray(): array;
}
