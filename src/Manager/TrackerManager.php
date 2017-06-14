<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Entity\Tracker;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Normalizer\Entity\TrackerNormalizer;
use Appio\Redmine\Uri\TrackersCollectionUri;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
class TrackerManager
{
    const DEFAULT_TRACKER_ID = 5;

    /** @var ObjectFetcher */
    private $fetcher;

    /** @var TrackerNormalizer */
    private $denormalizer;

    /** @var Tracker[] */
    private $trackers;

    /**
     * @param ObjectFetcher $fetcher
     * @param TrackerNormalizer $denormalizer
     */
    public function __construct(ObjectFetcher $fetcher, TrackerNormalizer $denormalizer)
    {
        $this->fetcher = $fetcher;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param array $options
     * @return Tracker[]
     * @throws ResponseException
     * @throws UnexpectedValueException
     */
    public function findAll(array $options = []): array
    {
        return $this->fetchAll($options);
    }

    /**
     * @param array $options
     * @return Tracker
     * @throws \Appio\Redmine\Exception\EntityNotFoundException
     */
    public function getDefaultTracker(array $options = []): Tracker
    {
        try {
            $this->fetchAll($options);
        } catch (\Exception $exception) {
            throw new EntityNotFoundException('Default tracker was not found.', $exception);
        }

        $default = array_filter($this->trackers, function (Tracker $tracker) {
            return $tracker->getId() === self::DEFAULT_TRACKER_ID;
        });

        if (count($default) === 0) {
            throw new EntityNotFoundException('Default tracker was not found.');
        }

        return array_pop($default);
    }

    /**
     * @param int $id
     * @param array $options
     * @return Tracker
     * @throws EntityNotFoundException
     */
    public function get(int $id, array $options = []): Tracker
    {
        try {
            $this->fetchAll($options);
        } catch (\Exception $exception) {
            if ($exception instanceof ResponseException || $exception instanceof UnexpectedValueException) {
                throw new EntityNotFoundException(sprintf('Tracker with id "%d" was not found.', $id), $exception);
            }
        }
        if (array_key_exists($id, $this->trackers)) {
            return $this->trackers[$id];
        }
        throw new EntityNotFoundException(sprintf('Tracker with id "%d" was not found.', $id));
    }

    /**
     * @param array $options
     * @return Tracker[]
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    private function fetchAll(array $options = []): array
    {
        if ($this->trackers === null) {
            $this->trackers = $this->fetcher->fetchAll(new TrackersCollectionUri($this->denormalizer), $options);
        }

        return $this->trackers;
    }
}
