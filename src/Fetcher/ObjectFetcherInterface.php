<?php
declare(strict_types=1);

namespace Appio\Redmine\Fetcher;

use Appio\Redmine\Collection\CollectionInterface;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Uri\CollectionUriInterface;
use Appio\Redmine\Uri\UriInterface;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
interface ObjectFetcherInterface
{
    /**
     * @param UriInterface $uri
     * @param array $options
     * @return mixed
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    public function fetch(UriInterface $uri, array $options = []);

    /**
     * @param CollectionUriInterface $uri
     * @param array $options
     * @return CollectionInterface
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    public function fetchCollection(CollectionUriInterface $uri, array $options = []): CollectionInterface;

    /**
     * @param CollectionUriInterface $uri
     * @param array $options
     * @return array
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    public function fetchAll(CollectionUriInterface $uri, array $options = []): array;
}
