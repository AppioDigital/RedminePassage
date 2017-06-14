<?php
declare(strict_types=1);

namespace Appio\Redmine\Fetcher;

use Appio\Redmine\Uri\UriInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 */
class ArrayFetcher
{
    /**
     * @var StreamFetcher
     */
    private $streamFetcher;

    /**
     * @var JsonEncoder
     */
    private $decoder;

    /**
     * @param StreamFetcher $streamFetcher
     * @param JsonEncoder $decoder
     */
    public function __construct(StreamFetcher $streamFetcher, JsonEncoder $decoder)
    {
        $this->streamFetcher = $streamFetcher;
        $this->decoder = $decoder;
    }

    /**
     * @param UriInterface $uri
     * @param array $options
     * @return array
     * @throws \Symfony\Component\Serializer\Exception\UnexpectedValueException
     * @throws \Appio\Redmine\Exception\ResponseException
     */
    public function fetch(UriInterface $uri, array $options = []): array
    {
        $stream = $this->streamFetcher->fetch($uri, $options);

        return $this->decoder->decode($stream, 'json');
    }
}
