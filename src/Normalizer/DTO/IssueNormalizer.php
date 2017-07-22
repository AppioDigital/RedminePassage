<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\DTO;

use Appio\Redmine\DTO\Issue;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 */
class IssueNormalizer implements NormalizerInterface
{
    /** @var NormalizerInterface */
    private $normalizer;

    /**
     * @param NormalizerInterface $normalizer
     */
    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * {@inheritdoc}
     * @param Issue $object
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        $i = [];
        if ($object->hasId()) {
            $i['id'] = $object->getId();
        }
        if ($object->hasProjectId()) {
            $i['project_id'] = $object->getProjectId();
        }
        if ($object->hasTrackerId()) {
            $i['tracker_id'] = $object->getTrackerId();
        }
        if ($object->hasStatusId()) {
            $i['status_id'] = $object->getStatusId();
        }
        if ($object->hasPriorityId()) {
            $i['priority_id'] = $object->getPriorityId();
        }
        if ($object->hasAssignedToId()) {
            $i['assigned_to_id'] = $object->getAssignedToId();
        }
        if ($object->hasDescription()) {
            $i['description'] = $object->getDescription();
        }
        if ($object->hasNotes()) {
            $i['notes'] = $object->getNotes();
            if ($object->hasPrivateNotes()) {
                $i['private_notes'] = $object->isPrivateNotes();
            }
        }
        if ($object->hasSubject()) {
            $i['subject'] = $object->getSubject();
        }
        if ($object->hasStartDate()) {
            $i['start_date'] = $object->getStartDate();
        }
        if ($object->hasDueDate()) {
            $i['due_date'] = $object->getDueDate();
        }
        if ($object->hasUploads()) {
            $i['uploads'] = [];
            foreach ($object->getUploads() as $upload) {
                $i['uploads'][] = $this->normalizer->normalize($upload, $format, $context);
            }
        }
        if ($object->hasCustomFields()) {
            $i['custom_fields'] = [];
            foreach ($object->getCustomFields() as $customField) {
                $i['custom_fields'][] = $this->normalizer->normalize($customField, $format, $context);
            }
        }

        return ['issue' => $i];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Issue && $format === 'json';
    }
}
