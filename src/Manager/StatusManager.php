<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Entity\Status;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Normalizer\Entity\StatusNormalizer;
use Appio\Redmine\Uri\StatusesCollectionUri;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
class StatusManager
{
    const DEFAULT_STATUS_ID = 1;

    /**@var ObjectFetcher */
    private $fetcher;

    /** @var StatusNormalizer */
    private $denormalizer;

    /** @var Status[] */
    private $statuses;

    /**
     * @param ObjectFetcher $fetcher
     * @param StatusNormalizer $denormalizer
     */
    public function __construct(ObjectFetcher $fetcher, StatusNormalizer $denormalizer)
    {
        $this->fetcher = $fetcher;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param array $options
     * @return Status[]
     * @throws ResponseException
     * @throws UnexpectedValueException
     */
    public function findAll(array $options = []): array
    {
        return $this->fetchAll($options);
    }

    /**
     * @param array $options
     * @return Status
     * @throws \Appio\Redmine\Exception\EntityNotFoundException
     */
    public function getDefaultStatus(array $options = []): Status
    {
        try {
            $this->fetchAll($options);
        } catch (\Exception $exception) {
            throw new EntityNotFoundException('Default status was not found.', $exception);
        }

        $default = array_filter($this->statuses, function (Status $status) {
            return $status->getId() === self::DEFAULT_STATUS_ID;
        });

        if (count($default) === 0) {
            throw new EntityNotFoundException('Default status was not found.');
        }

        return array_pop($default);
    }

    /**
     * @param $id
     * @param array $options
     * @return Status
     * @throws EntityNotFoundException
     */
    public function get(int $id, array $options = []): Status
    {
        try {
            $this->fetchAll($options);
        } catch (\Exception $exception) {
            if ($exception instanceof ResponseException || $exception instanceof UnexpectedValueException) {
                throw new EntityNotFoundException(sprintf('Status with id "%d" was not found.', $id), $exception);
            }
        }
        if (array_key_exists($id, $this->statuses)) {
            return $this->statuses[$id];
        }
        throw new EntityNotFoundException(sprintf('Status with id "%d" was not found.', $id));
    }

    /**
     * @param array $options
     * @return Status[]
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    private function fetchAll(array $options = []): array
    {
        if ($this->statuses === null) {
            $this->statuses = $this->fetcher->fetchAll(new StatusesCollectionUri($this->denormalizer), $options);
        }

        return $this->statuses;
    }
}
