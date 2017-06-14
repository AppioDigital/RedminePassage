<?php
declare(strict_types=1);

namespace Appio\Redmine\Collection;

use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Uri\CollectionUriInterface;

/**
 */
interface CollectionInterface extends \Countable
{
    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @param ObjectFetcher $fetcher
     * @param CollectionUriInterface $uri
     * @param array $options
     * @return array
     * @throws \Appio\Redmine\Exception\ResponseException
     * @throws \Symfony\Component\Serializer\Exception\UnexpectedValueException
     */
    public function handleAll(ObjectFetcher $fetcher, CollectionUriInterface $uri, array $options = []): array;
}
