<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer\Entity;

use Appio\Redmine\Entity\Attachment;
use Appio\Redmine\Entity\CustomField;
use Appio\Redmine\Entity\Issue;
use Appio\Redmine\Entity\IssueProject;
use Appio\Redmine\Entity\Priority;
use Appio\Redmine\Entity\Status;
use Appio\Redmine\Entity\Tracker;
use Appio\Redmine\Entity\User;
use Appio\Redmine\Normalizer\DenormalizerTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
class IssueNormalizer implements DenormalizerInterface
{
    const ISSUE_KEY = 'issue';

    const DESCRIPTION_KEY = 'description';

    const PROJECT_KEY = 'project';

    const TRACKER_KEY = 'tracker';

    const PRIORITY_KEY = 'priority';

    const STATUS_KEY = 'status';

    const AUTHOR_KEY = 'author';

    const ASSIGNED_TO_KEY = 'assigned_to';

    const CREATED_ON_KEY = 'created_on';

    const UPDATED_ON_KEY = 'updated_on';

    const START_DATE_KEY = 'start_date';

    const DUE_DATE_KEY = 'due_date';

    const ATTACHMENTS_KEY = 'attachments';

    const CUSTOM_FIELDS_KEY = 'custom_fields';

    use DenormalizerTrait;

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;

    /**
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }

    /**
     * {@inheritdoc}
     * @return Issue
     * @throws \InvalidArgumentException
     */
    public function denormalize($data, $class, $format = null, array $context = []): Issue
    {
        $objectData = $this->getObjectData($data, self::ISSUE_KEY);
        if (array_key_exists(self::DESCRIPTION_KEY, $objectData) === false) {
            $objectData[self::DESCRIPTION_KEY] = '';
        }

        /** @var IssueProject $project */
        $project = $this->denormalizer->denormalize(
            $objectData[self::PROJECT_KEY],
            IssueProject::class,
            $format,
            $context
        );

        /** @var Tracker $tracker */
        $tracker = $this->denormalizer->denormalize($objectData[self::TRACKER_KEY], Tracker::class, $format, $context);

        /** @var Priority $priority */
        $priority = $this->denormalizer->denormalize(
            $objectData[self::PRIORITY_KEY],
            Priority::class,
            $format,
            $context
        );

        /** @var Status $status */
        $status = $this->denormalizer->denormalize($objectData[self::STATUS_KEY], Status::class, $format, $context);

        /** @var User $author */
        $author = $this->denormalizer->denormalize($objectData[self::AUTHOR_KEY], User::class, $format, $context);

        /** @var User|null $assignedTo */
        $assignedTo = null;

        if (array_key_exists(self::ASSIGNED_TO_KEY, $objectData) === true) {
            $assignedTo = $this->denormalizer->denormalize(
                $objectData[self::ASSIGNED_TO_KEY],
                User::class,
                $format,
                $context
            );
        }

        $createdOn = new \DateTime($objectData[self::CREATED_ON_KEY]);

        $startDate = (
            array_key_exists(self::START_DATE_KEY, $objectData) === true &&
            empty($objectData[self::START_DATE_KEY]) === false
        ) ?
            new \DateTime($objectData[self::START_DATE_KEY]) :
            null;

        $updatedOn = (
            array_key_exists(self::UPDATED_ON_KEY, $objectData) === true &&
            empty($objectData[self::UPDATED_ON_KEY]) === false
        ) ?
            new \DateTime($objectData[self::UPDATED_ON_KEY]) :
            null;

        $dueDate = (array_key_exists(self::DUE_DATE_KEY, $objectData) === true &&
            empty($objectData[self::DUE_DATE_KEY]) === false
        ) ?
            new \DateTime($objectData[self::DUE_DATE_KEY]) :
            null;

        $attachments = [];
        if (array_key_exists(self::ATTACHMENTS_KEY, $objectData)) {
            /** @var array $arrayAttachments */
            $arrayAttachments = $objectData[self::ATTACHMENTS_KEY];
            foreach ($arrayAttachments as $arrayAttachment) {
                $attachments[] = $this->denormalizer->denormalize(
                    $arrayAttachment,
                    Attachment::class,
                    $format,
                    $context
                );
            }
        }

        $customFields = [];
        if (array_key_exists(self::CUSTOM_FIELDS_KEY, $objectData)) {
            /** @var array $arrayCustomFields */
            $arrayCustomFields = $objectData[self::CUSTOM_FIELDS_KEY];
            foreach ($arrayCustomFields as $arrayCustomField) {
                $customFields[] = $this->denormalizer->denormalize(
                    $arrayCustomField,
                    CustomField::class,
                    $format,
                    $context
                );
            }
        }

        return Issue::createFromArray(
            $objectData,
            $project,
            $tracker,
            $priority,
            $status,
            $author,
            $createdOn,
            $startDate,
            $updatedOn,
            $dueDate,
            $assignedTo,
            $attachments,
            $customFields
        );
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Issue::class && $format === 'json';
    }
}
