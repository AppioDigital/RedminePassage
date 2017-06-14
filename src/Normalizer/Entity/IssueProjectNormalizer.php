<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\IssueProject;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class IssueProjectNormalizer implements DenormalizerInterface
{
    /**
     * {@inheritdoc}
     * @return IssueProject
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): IssueProject
    {
        return IssueProject::createFromArray($data);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === IssueProject::class && $format === 'json';
    }
}
