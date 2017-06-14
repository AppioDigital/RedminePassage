<?php
declare(strict_types=1);

namespace Tests\Fetcher;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Appio\Redmine\Collection\CollectionInterface;
use Appio\Redmine\Fetcher\ArrayFetcher;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Fetcher\ObjectFetcherInterface;
use Appio\Redmine\Fetcher\StreamFetcher;
use GuzzleHttp\Handler\MockHandler;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Appio\Redmine\Uri\PaginatedCollectionUri;
use Appio\Redmine\Uri\ProjectCollectionUri;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 */
class ObjectCollectionFetcherTest extends TestCase
{
    /**
     * Datasource: response-data/projects-full.json
     * @return array
     */
    public function objectCollectionIsCreatedProvider(): array
    {
        $defaultLimit = PaginatedCollectionUri::DEFAULT_LIMIT;
        $defaultOffset = PaginatedCollectionUri::DEFAULT_OFFSET;
        $body1 = sprintf(
            file_get_contents(__DIR__ . '/response-data/projects-full.json'),
            $defaultOffset,
            $defaultLimit
        );

        $mockHandler = new MockHandler([
            new Response(200, [], $body1)
        ]);

        $handler = HandlerStack::create($mockHandler);
        $fakeClient = new Client(['handler' => $handler]);
        $httpClient = new \Http\Adapter\Guzzle6\Client($fakeClient);
        $streamFetcher = new StreamFetcher($httpClient, new GuzzleMessageFactory);
        $arrayFetcher = new ArrayFetcher($streamFetcher, new JsonEncoder());
        $objectFetcher = new ObjectFetcher($arrayFetcher);

        return [[[
            'fetcher' => $objectFetcher,
            'limit' => $defaultLimit,
            'offset' => $defaultOffset,
            'uri' => new ProjectCollectionUri(new ProjectNormalizer(), $defaultLimit, $defaultOffset)
        ]]];
    }

    /**
     * @return array
     */
    public function allObjectsAreFetchedProvider(): array
    {
        $body1 = file_get_contents(__DIR__ . '/response-data/projects-main.json');
        $body2 = file_get_contents(__DIR__ . '/response-data/projects-main2.json');

        $mockHandler = new MockHandler([
            new Response(200, [], $body1),
            new Response(200, [], $body2)
        ]);

        $handler = HandlerStack::create($mockHandler);
        $fakeClient = new Client(['handler' => $handler]);
        $httpClient = new \Http\Adapter\Guzzle6\Client($fakeClient);
        $streamFetcher = new StreamFetcher($httpClient, new GuzzleMessageFactory);
        $arrayFetcher = new ArrayFetcher($streamFetcher, new JsonEncoder());
        $objectFetcher = new ObjectFetcher($arrayFetcher);

        return [[[
            'fetcher' => $objectFetcher,
            'total_count' => 3,
            'uri' => new ProjectCollectionUri(new ProjectNormalizer(), 2, 0)
        ]]];
    }

    /**
     * @dataProvider objectCollectionIsCreatedProvider
     * @param array $data
     */
    public function testThatObjectCollectionIsCreated(array $data): void
    {
        /**
         * @var ObjectFetcherInterface $objectFetcher
         */
        $objectFetcher = $data['fetcher'];
        $this->assertInstanceOf(CollectionInterface::class, $objectFetcher->fetchCollection($data['uri']));
    }

    /**
     * @dataProvider allObjectsAreFetchedProvider
     * @param array $data
     */
    public function testThatAllObjectsAreFetched(array $data): void
    {
        /**
         * @var ObjectFetcherInterface $objectFetcher
         */
        $objectFetcher = $data['fetcher'];
        /**
         * @var array
         */
        $objects = $objectFetcher->fetchAll($data['uri']);
        $this->assertCount($data['total_count'], $objects);
    }

    /**
     *
     */
    public function tearDown(): void
    {
        m::close();
    }
}
