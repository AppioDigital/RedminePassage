<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Appio\Redmine\Entity\Project;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class ProjectUri extends Uri
{
    /** @var ProjectNormalizer */
    private $denormalizer;

    /**
     * @param int $id
     * @param ProjectNormalizer $denormalizer
     * @param array $params
     */
    public function __construct(int $id, ProjectNormalizer $denormalizer, array $params = [])
    {
        parent::__construct(Project::class, "projects/$id.json", $params);
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function getDenormalizer(): DenormalizerInterface
    {
        return $this->denormalizer;
    }
}
