<?php
declare(strict_types=1);

namespace Tests\Fetcher;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamInterface;
use Appio\Redmine\Fetcher\StreamFetcher;
use GuzzleHttp\Handler\MockHandler;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Appio\Redmine\Uri\ProjectCollectionUri;

/**
 */
class StreamFetcherTest extends TestCase
{
    /**
     *
     */
    public function testThatResponseIsOk(): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], '{}')
        ]);
        $handler = HandlerStack::create($mockHandler);
        $fakeClient = new Client(['handler' => $handler]);
        $httpClient = new \Http\Adapter\Guzzle6\Client($fakeClient);
        $streamFetcher = new StreamFetcher($httpClient, new GuzzleMessageFactory);
        $this->assertInstanceOf(
            StreamInterface::class,
            $streamFetcher->fetch(new ProjectCollectionUri(new ProjectNormalizer()))
        );
    }

    /**
     * @expectedException \Appio\Redmine\Exception\ResponseException
     */
    public function testThatResponseIsNotOk(): void
    {
        $mockHandler = new MockHandler([
            new Response(500, [])
        ]);
        $handler = HandlerStack::create($mockHandler);
        $fakeClient = new Client(['handler' => $handler]);
        $httpClient = new \Http\Adapter\Guzzle6\Client($fakeClient);
        $streamFetcher = new StreamFetcher($httpClient, new GuzzleMessageFactory);
        $streamFetcher->fetch(new ProjectCollectionUri(new ProjectNormalizer()));
    }

    /**
     *
     */
    public function tearDown(): void
    {
        m::close();
    }
}
