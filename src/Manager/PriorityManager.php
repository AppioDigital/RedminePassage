<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Entity\Priority;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Normalizer\Entity\PriorityNormalizer;
use Appio\Redmine\Uri\PrioritiesCollectionUri;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
class PriorityManager
{
    /** @var ObjectFetcher */
    private $fetcher;

    /** @var PriorityNormalizer */
    private $denormalizer;

    /** @var Priority[] */
    private $priorities;

    /**
     * @param ObjectFetcher $fetcher
     * @param PriorityNormalizer $denormalizer
     */
    public function __construct(ObjectFetcher $fetcher, PriorityNormalizer $denormalizer)
    {
        $this->fetcher = $fetcher;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param array $options
     * @return Priority[]
     * @throws ResponseException
     * @throws UnexpectedValueException
     */
    public function findAll(array $options = []): array
    {
        $this->fetchAll($options);
        return $this->priorities;
    }

    /**
     * @param int $id
     * @param array $options
     * @return Priority
     * @throws EntityNotFoundException
     */
    public function get(int $id, array $options = []): Priority
    {
        try {
            $this->fetchAll($options);
        } catch (\Exception $exception) {
            if ($exception instanceof ResponseException || $exception instanceof UnexpectedValueException) {
                throw new EntityNotFoundException(sprintf('Priority with id "%d" was not found.', $id), $exception);
            }
        }

        if (array_key_exists($id, $this->priorities)) {
            return $this->priorities[$id];
        }

        throw new EntityNotFoundException(sprintf('Priority with id "%d" was not found.', $id));
    }

    /**
     * @param array $options
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    private function fetchAll(array $options = []): void
    {
        if ($this->priorities === null) {
            $this->priorities = $this->fetcher->fetchAll(new PrioritiesCollectionUri($this->denormalizer), $options);
        }
    }
}
