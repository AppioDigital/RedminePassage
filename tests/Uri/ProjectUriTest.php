<?php
declare(strict_types=1);

namespace Tests\Uri;

use PHPUnit\Framework\TestCase;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Appio\Redmine\Uri\PaginatedCollectionUri;
use Appio\Redmine\Uri\ProjectCollectionUri;
use Appio\Redmine\Uri\ProjectUri;

/**
 */
class ProjectUriTest extends TestCase
{
    /**
     * @return array
     */
    public function validProjectUriProvider(): array
    {
        return [
            [['id' => 1, 'expected' => 'projects/1.json']],
            [['id' => null, 'expected' => 'projects/0.json']],
        ];
    }

    /**
     * @return array
     */
    public function validProjectCollectionUriProvider(): array
    {
        $defaultLimit = PaginatedCollectionUri::DEFAULT_LIMIT;
        $defaultOffset = PaginatedCollectionUri::DEFAULT_OFFSET;
        return [
            [[
                'limit' => null,
                'offset' => null,
                'expected' => "projects.json?limit={$defaultLimit}&offset={$defaultOffset}"
            ]],
            [[
                'limit' => null,
                'offset' => 10,
                'expected' => "projects.json?limit={$defaultLimit}&offset=10"
            ]],
            [[
                'limit' => 10,
                'offset' => null,
                'expected' => "projects.json?limit=10&offset={$defaultOffset}"
            ]]
        ];
    }

    /**
     * @dataProvider validProjectUriProvider
     * @param array $data
     */
    public function testThatProjectUriIsValid(array $data): void
    {
        $uri = new ProjectUri((int) $data['id'], new ProjectNormalizer());
        $this->assertEquals($data['expected'], (string) $uri);
    }

    /**
     * @dataProvider validProjectCollectionUriProvider
     * @param array $data
     */
    public function testThatProjectCollectionUriIsValid(array $data): void
    {
        $uri = new ProjectCollectionUri(new ProjectNormalizer(), $data['limit'], $data['offset']);
        $this->assertEquals($data['expected'], (string) $uri);
    }
}
