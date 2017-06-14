<?php
declare(strict_types=1);

namespace Appio\Redmine\DTO;

use Appio\Redmine\Entity\CustomFieldInterface;
use Appio\Redmine\Entity\Upload;

/**
 */
class Issue
{
    /** @var int */
    private $id;

    /** @var int */
    private $projectId;

    /** @var int */
    private $trackerId;

    /** @var int */
    private $statusId;

    /** @var int */
    private $priorityId;

    /** @var int */
    private $assignedToId;

    /** @var string */
    private $subject;

    /** @var string */
    private $description;

    /** @var string */
    private $startDate;

    /** @var string */
    private $dueDate;

    /** @var CustomFieldInterface[] */
    private $customFields;

    /** @var Upload[] */
    private $uploads;

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param int $projectId
     */
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    /**
     * @param int $trackerId
     */
    public function setTrackerId(int $trackerId): void
    {
        $this->trackerId = $trackerId;
    }

    /**
     * @param int $statusId
     */
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    /**
     * @param int $priorityId
     */
    public function setPriorityId(int $priorityId): void
    {
        $this->priorityId = $priorityId;
    }

    /**
     * @param int $assignedToId
     */
    public function setAssignedToId(int $assignedToId): void
    {
        $this->assignedToId = $assignedToId;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param Upload[] $uploads
     */
    public function setUploads(array $uploads): void
    {
        $this->uploads = $uploads;
    }

    /**
     * @param CustomFieldInterface[] $customFields
     */
    public function setCustomFields(array $customFields): void
    {
        $this->customFields = $customFields;
    }

    /**
     * @return CustomFieldInterface[]
     */
    public function getCustomFields(): array
    {
        return $this->customFields ?? [];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    /**
     * @return int|null
     */
    public function getTrackerId(): ?int
    {
        return $this->trackerId;
    }

    /**
     * @return int|null
     */
    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    /**
     * @return int|null
     */
    public function getPriorityId(): ?int
    {
        return $this->priorityId;
    }

    /**
     * @return int|null
     */
    public function getAssignedToId(): ?int
    {
        return $this->assignedToId;
    }

    /**
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return Upload[]
     */
    public function getUploads(): array
    {
        return $this->uploads;
    }

    /**
     * @return bool
     */
    public function hasId(): bool
    {
        return $this->id !== null;
    }

    /**
     * @return bool
     */
    public function hasProjectId(): bool
    {
        return $this->projectId !== null;
    }

    /**
     * @return bool
     */
    public function hasTrackerId(): bool
    {
        return $this->trackerId !== null;
    }

    /**
     * @return bool
     */
    public function hasStatusId(): bool
    {
        return $this->statusId !== null;
    }

    /**
     * @return bool
     */
    public function hasPriorityId(): bool
    {
        return $this->priorityId !== null;
    }

    /**
     * @return bool
     */
    public function hasAssignedToId(): bool
    {
        return $this->assignedToId !== null;
    }

    /**
     * @return bool
     */
    public function hasSubject(): bool
    {
        return $this->subject !== null;
    }

    /**
     * @return bool
     */
    public function hasDescription(): bool
    {
        return $this->description !== null;
    }

    /**
     * @return bool
     */
    public function hasUploads(): bool
    {
        return $this->uploads !== null && count($this->uploads) > 0;
    }

    /**
     * @return bool
     */
    public function hasCustomFields(): bool
    {
        return $this->customFields !== null && count($this->customFields) > 0;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string|null
     */
    public function getDueDate(): ?string
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     */
    public function setDueDate(string $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return bool
     */
    public function hasStartDate(): bool
    {
        return $this->startDate !== null;
    }

    /**
     * @return bool
     */
    public function hasDueDate(): bool
    {
        return $this->dueDate !== null;
    }

    /**
     * @return string
     */
    public function getRequestMethod(): string
    {
        if ($this->hasId()) {
            return 'PUT';
        }
        return 'POST';
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        if ($this->hasId()) {
            return sprintf('issues/%d.json', $this->id);
        }
        return 'issues.json';
    }
}
