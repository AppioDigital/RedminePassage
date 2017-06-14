<?php
declare(strict_types=1);

namespace Tests\Fetcher;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Appio\Redmine\Entity\Project;
use Appio\Redmine\Fetcher\ArrayFetcher;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Fetcher\StreamFetcher;
use GuzzleHttp\Handler\MockHandler;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Appio\Redmine\Uri\ProjectUri;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 */
class ObjectFetcherTest extends TestCase
{
    /**
     * @return array
     */
    public function objectIsCreatedProvider(): array
    {
        $body1 = file_get_contents(__DIR__ . '/response-data/project-xcore.json');
        return [[['body' => $body1]]];
    }

    /**
     * @dataProvider objectIsCreatedProvider
     * @param array $data
     */
    public function testThatObjectIsCreated(array $data): void
    {
        $mockHandler = new MockHandler([
            new Response(200, [], $data['body'])
        ]);
        $handler = HandlerStack::create($mockHandler);
        $fakeClient = new Client(['handler' => $handler]);
        $httpClient = new \Http\Adapter\Guzzle6\Client($fakeClient);
        $streamFetcher = new StreamFetcher($httpClient, new GuzzleMessageFactory);
        $arrayFetcher = new ArrayFetcher($streamFetcher, new JsonEncoder());
        $objectFetcher = new ObjectFetcher($arrayFetcher);
        $this->assertInstanceOf(Project::class, $objectFetcher->fetch(new ProjectUri(2, new ProjectNormalizer())));
    }

    /**
     *
     */
    public function tearDown(): void
    {
        m::close();
    }
}
