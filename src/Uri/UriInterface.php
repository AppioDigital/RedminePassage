<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
interface UriInterface
{
    /**
     * @return string
     */
    public function getClass(): string;

    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return DenormalizerInterface
     */
    public function getDenormalizer(): DenormalizerInterface;

    /**
     * @return string
     */
    public function __toString(): string;

    /**
     * @return bool
     */
    public function hasIdGetter(): bool;

    /**
     * @return string[]
     */
    public function getParams(): array;
}
