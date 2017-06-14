<?php
declare(strict_types=1);

namespace Appio\Redmine\Fetcher;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Psr\Http\Message\StreamInterface;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Uri\UriInterface;

/**
 */
class StreamFetcher
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * StreamFetcher constructor.
     * @param HttpClient $client
     * @param MessageFactory $messageFactory
     */
    public function __construct(HttpClient $client, MessageFactory $messageFactory)
    {
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param UriInterface $uri
     * @param array $options
     * @return StreamInterface
     * @throws ResponseException
     */
    public function fetch(UriInterface $uri, array $options = []): StreamInterface
    {
        try {
            $request = $this->messageFactory->createRequest('GET', (string) $uri, $options);
            $response = $this->client->sendRequest($request);

            if ($response->getStatusCode() !== 200) {
                throw new ResponseException($response->getReasonPhrase(), $response->getStatusCode());
            }
        } catch (\Exception $exception) {
            throw new ResponseException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $response->getBody();
    }
}
