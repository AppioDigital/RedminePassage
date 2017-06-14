<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Exception;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Appio\Redmine\Entity\Issue;
use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Uri\IssueUri;
use Appio\Redmine\Uri\ProjectIssuesCollectionUri;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Appio\Redmine\DTO\Issue as DTOIssue;
use Appio\Redmine\Normalizer\Entity\IssueNormalizer;
use Appio\Redmine\Normalizer\DTO\IssueNormalizer as DTOIssueNormalizer;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
class IssueManager
{
    /** @var ObjectFetcher */
    private $fetcher;

    /** @var HttpClient */
    private $client;

    /** @var MessageFactory */
    private $messageFactory;

    /** @var IssueNormalizer */
    private $denormalizer;

    /** @var DTOIssueNormalizer */
    private $normalizer;

    /** @var JsonEncoder */
    private $encoder;

    /**
     * @param ObjectFetcher $fetcher
     * @param IssueNormalizer $denormalizer
     * @param DTOIssueNormalizer $normalizer
     * @param JsonEncoder $encoder
     * @param HttpClient $client
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        ObjectFetcher $fetcher,
        IssueNormalizer $denormalizer,
        DTOIssueNormalizer $normalizer,
        JsonEncoder $encoder,
        HttpClient $client,
        MessageFactory $messageFactory
    ) {
        $this->fetcher = $fetcher;
        $this->denormalizer = $denormalizer;
        $this->normalizer = $normalizer;
        $this->encoder = $encoder;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param int $projectId
     * @param array $params
     * @param array $options
     * @return Issue[]
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    public function findAllByProject(int $projectId, array $params = [], array $options = []): array
    {
        return $this->fetcher->fetchAll(
            new ProjectIssuesCollectionUri(
                $projectId,
                $this->denormalizer,
                ProjectIssuesCollectionUri::DEFAULT_LIMIT,
                ProjectIssuesCollectionUri::DEFAULT_OFFSET,
                $params
            ),
            $options
        );
    }

    /**
     * @param int $id
     * @param array $options
     * @return Issue
     * @throws EntityNotFoundException
     */
    public function get(int $id, array $options = []): Issue
    {
        $issue = null;
        try {
            $issue = $this->fetcher->fetch(new IssueUri($id, $this->denormalizer), $options);
        } catch (ResponseException | UnexpectedValueException $exception) {
            throw new EntityNotFoundException(sprintf('Issue with id "%d" was not found.', $id), $exception);
        } catch (Exception $exception) {
            throw new EntityNotFoundException(
                sprintf('There was an error during fetching of issue with id "%d".', $id),
                $exception
            );
        }

        return $issue;
    }

    /**
     * @param DTOIssue $issue
     * @param array $options
     * @return Issue
     * @throws Exception
     * @throws UnexpectedValueException
     * @throws ResponseException
     */
    public function save(DTOIssue $issue, array $options = []): Issue
    {
        $normalized = $this->normalizer->normalize($issue, 'json');

        /** @var string $body */
        $body = $this->encoder->encode($normalized, 'json');

        $request = $this->messageFactory->createRequest(
            $issue->getRequestMethod(),
            $issue->getUri(),
            $options,
            $body
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (\Exception $exception) {
            throw new ResponseException($exception->getMessage(), $exception->getCode());
        }

        $code = $response->getStatusCode();

        if ($code !== 201 && $code !== 200) {
            throw new ResponseException((string) $response->getBody(), $response->getStatusCode());
        }

        if ($code === 201) {
            $newIssue = $this->encoder->decode($response->getBody(), 'json');
            return $this->denormalizer->denormalize($newIssue, Issue::class, 'json');
        }

        if ($issue->getId() === null) {
            throw new \RuntimeException;
        }

        return $this->fetcher->fetch(new IssueUri($issue->getId(), $this->denormalizer), $options);
    }
}
