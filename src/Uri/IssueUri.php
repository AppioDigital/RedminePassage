<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Issue;
use Appio\Redmine\Normalizer\Entity\IssueNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class IssueUri extends Uri
{
    /** @var IssueNormalizer */
    private $denormalizer;

    /**
     * @param int $id
     * @param IssueNormalizer $denormalizer
     * @param array $params
     */
    public function __construct(int $id, IssueNormalizer $denormalizer, array $params = [])
    {
        parent::__construct(Issue::class, "issues/$id.json", $params);
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getDenormalizer(): DenormalizerInterface
    {
        return $this->denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultParams(): array
    {
        return array_merge(parent::getDefaultParams(), ['include' => 'attachments']);
    }
}
