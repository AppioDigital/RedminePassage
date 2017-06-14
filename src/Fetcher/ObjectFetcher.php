<?php
declare(strict_types=1);

namespace Appio\Redmine\Fetcher;

use Appio\Redmine\Collection\Collection;
use Appio\Redmine\Collection\CollectionInterface;
use Appio\Redmine\Collection\PaginatedCollection;
use Appio\Redmine\Uri\CollectionUriInterface;
use Appio\Redmine\Uri\UriInterface;

/**
 */
final class ObjectFetcher implements ObjectFetcherInterface
{
    /** @var ArrayFetcher */
    private $arrayFetcher;

    /**
     * @param ArrayFetcher $arrayFetcher
     */
    public function __construct(ArrayFetcher $arrayFetcher)
    {
        $this->arrayFetcher = $arrayFetcher;
    }

    /**
     * {@inheritdoc}
     */
    public function fetch(UriInterface $uri, array $options = [])
    {
        $arrayObject = $this->arrayFetcher->fetch($uri, $options);
        $denormalizer = $uri->getDenormalizer();
        return $denormalizer->denormalize($arrayObject, $uri->getClass(), 'json');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchCollection(CollectionUriInterface $uri, array $options = []): CollectionInterface
    {
        /**
         * @var array $arrayObjects
         * @var array $decoded
         */
        $decoded = $this->arrayFetcher->fetch($uri, $options);
        $denormalizer = $uri->getDenormalizer();
        $arrayObjects = $decoded[$uri->getCollectionKey()];

        if ($uri->hasIdGetter() === true) {
            $objects = [];
            foreach ($arrayObjects as $arrayObject) {
                $object = $denormalizer->denormalize($arrayObject, $uri->getClass(), 'json');
                $objects[$object->getId()] = $object;
            }
        } else {
            $objects = array_map(function ($arrayObject) use ($uri, $denormalizer) {
                return $denormalizer->denormalize($arrayObject, $uri->getClass(), 'json');
            }, $arrayObjects[$uri->getCollectionKey()]);
        }

        if (isset($decoded['total_count'], $decoded['offset'], $decoded['limit'])) {
            return new PaginatedCollection($objects, $decoded['total_count'], $decoded['offset'], $decoded['limit']);
        }

        return new Collection($objects);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll(CollectionUriInterface $uri, array $options = []): array
    {
        $first = $this->fetchCollection($uri, $options);

        return $first->handleAll($this, $uri, $options);
    }
}
