<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use DateTime;
use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Issue
{
    const ID_KEY = 'id';

    const SUBJECT_KEY = 'subject';

    const DESCRIPTION_KEY = 'description';

    const DONE_RATIO_KEY = 'done_ratio';

    const ESTIMATED_HOURS_KEY = 'estimated_hours';

    const TOTAL_ESTIMATED_HOURS_KEY = 'total_estimated_hours';

    const ADDITIONAL_COSTS_ID = 1;

    const ADDITIONAL_COST_NAME = 'Více práce';

    const ADDITIONAL_COSTS_FALSE_VALUE = '0';

    const ADDITIONAL_COSTS_TRUE_VALUE = '1';

    const CLIENT_AVAILABLE_ID = 3;

    const CLIENT_AVAILABLE_NAME = 'Viditelné klientem';

    const CLIENT_AVAILABLE_FALSE_VALUE = '0';

    const CLIENT_AVAILABLE_TRUE_VALUE = '1';

    /** @var int */
    private $id;

    /** @var IssueProject */
    private $project;

    /** @var string */
    private $subject;

    /** @var string */
    private $description;

    /** @var int */
    private $doneRatio;

    /** @var float|null */
    private $estimatedHours;

    /** @var float|null */
    private $totalEstimatedHours;

    /** @var Tracker */
    private $tracker;

    /** @var Priority */
    private $priority;

    /** @var Status */
    private $status;

    /** @var User */
    private $author;

    /** @var User|null */
    private $assignedTo;

    /** @var DateTime */
    private $createdOn;

    /** @var DateTime|null */
    private $startDate;

    /** @var DateTime */
    private $dueDate;

    /** @var DateTime */
    private $updatedOn;

    /** @var CustomField[] */
    private $customFields;

    /** @var Attachment[] */
    private $attachments;

    /** @var Journal[] */
    private $journals;

    /**
     * @param int $id
     * @param IssueProject $project
     * @param string $subject
     * @param string $description
     * @param int $doneRatio
     * @param Tracker $tracker
     * @param Priority $priority
     * @param Status $status
     * @param User $author
     * @param DateTime $createdOn
     * @param DateTime|null $startDate
     */
    public function __construct(
        int $id,
        IssueProject $project,
        string $subject,
        string $description,
        int $doneRatio,
        Tracker $tracker,
        Priority $priority,
        Status $status,
        User $author,
        DateTime $createdOn,
        ?DateTime $startDate
    ) {
        $this->id = $id;
        $this->project = $project;
        $this->subject = $subject;
        $this->description = $description;
        $this->doneRatio = $doneRatio;
        $this->tracker = $tracker;
        $this->priority = $priority;
        $this->status = $status;
        $this->author = $author;
        $this->attachments = [];
        $this->customFields = [];
        $this->createdOn = $createdOn;
        $this->startDate = $startDate;
    }

    /**
     * @param array $data
     * @param IssueProject $project
     * @param Tracker $tracker
     * @param Priority $priority
     * @param Status $status
     * @param User $author
     * @param DateTime $createdOn
     * @param DateTime|null $startDate
     * @param DateTime|null $updatedOn
     * @param DateTime|null $dueDate
     * @param User|null $assignedTo
     * @param Attachment[] $attachments
     * @param array $customFields
     * @param array $journals
     * @return Issue
     */
    public static function createFromArray(
        array $data,
        IssueProject $project,
        Tracker $tracker,
        Priority $priority,
        Status $status,
        User $author,
        DateTime $createdOn,
        ?DateTime $startDate = null,
        ?DateTime $updatedOn = null,
        ?DateTime $dueDate = null,
        User $assignedTo = null,
        array $attachments = [],
        array $customFields = [],
        array $journals = []
    ): Issue {

        CheckAttributeKeyUtil::checkKeys(
            $data,
            [self::ID_KEY, self::SUBJECT_KEY, self::DESCRIPTION_KEY, self::DONE_RATIO_KEY]
        );

        $issue = new self(
            $data[self::ID_KEY],
            $project,
            $data[self::SUBJECT_KEY],
            $data[self::DESCRIPTION_KEY],
            $data[self::DONE_RATIO_KEY],
            $tracker,
            $priority,
            $status,
            $author,
            $createdOn,
            $startDate
        );

        if ($updatedOn !== null) {
            $issue->setUpdatedOn($updatedOn);
        }

        if ($dueDate !== null) {
            $issue->setDueDate($dueDate);
        }

        $issue->setAttachments($attachments);
        $issue->setCustomFields($customFields);
        $issue->setJournals($journals);

        if ($assignedTo !== null) {
            $issue->setAssignedTo($assignedTo);
        }

        // estimated hours
        if (isset($data[self::ESTIMATED_HOURS_KEY])) {
            $issue->setEstimatedHours($data[self::ESTIMATED_HOURS_KEY]);
        }

        if (isset($data[self::TOTAL_ESTIMATED_HOURS_KEY])) {
            $issue->setTotalEstimatedHours($data[self::TOTAL_ESTIMATED_HOURS_KEY]);
        }

        return $issue;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return IssueProject
     */
    public function getProject(): IssueProject
    {
        return $this->project;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param $subject
     */
    public function setSubject($subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getDoneRatio(): int
    {
        return $this->doneRatio;
    }

    /**
     * @param int $doneRatio
     */
    public function setDoneRatio(int $doneRatio): void
    {
        $this->doneRatio = $doneRatio;
    }

    /**
     * @return float|null
     */
    public function getEstimatedHours(): ?float
    {
        return $this->estimatedHours;
    }

    /**
     * @param float|null $estimatedHours
     */
    public function setEstimatedHours(?float $estimatedHours): void
    {
        $this->estimatedHours = $estimatedHours;
    }

    /**
     * @return float|null
     */
    public function getTotalEstimatedHours(): ?float
    {
        return $this->totalEstimatedHours;
    }

    /**
     * @param float|null $totalEstimatedHours
     */
    public function setTotalEstimatedHours(?float $totalEstimatedHours): void
    {
        $this->totalEstimatedHours = $totalEstimatedHours;
    }

    /**
     * @return Tracker
     */
    public function getTracker(): Tracker
    {
        return $this->tracker;
    }

    /**
     * @param Tracker $tracker
     */
    public function setTracker(Tracker $tracker): void
    {
        $this->tracker = $tracker;
    }

    /**
     * @return Priority
     */
    public function getPriority(): Priority
    {
        return $this->priority;
    }

    /**
     * @param Priority $priority
     */
    public function setPriority(Priority $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @param Status $status
     */
    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return User|null
     */
    public function getAssignedTo(): ?User
    {
        return $this->assignedTo;
    }

    /**
     * @return bool
     */
    public function isAssigned(): bool
    {
        return $this->assignedTo !== null;
    }

    /**
     * @param User $assignedTo
     */
    public function setAssignedTo(User $assignedTo): void
    {
        $this->assignedTo = $assignedTo;
    }


    /**
     * @return Attachment[]
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }

    /**
     * @param Attachment[] $attachments
     */
    public function setAttachments(array $attachments): void
    {
        $this->attachments = $attachments;
    }

    /**
     * @return CustomField[]
     */
    public function getCustomFields(): array
    {
        return $this->customFields;
    }

    /**
     * @param CustomField[] $customFields
     */
    public function setCustomFields(array $customFields): void
    {
        $this->customFields = $customFields;
    }

    /**
     * @return Journal[]
     */
    public function getJournals(): array
    {
        return $this->journals;
    }

    /**
     * @param Journal[] $journals
     */
    public function setJournals(array $journals): void
    {
        $this->journals = $journals;
    }

    /**
     * @return bool
     */
    public function isUpdated(): bool
    {
        return $this->updatedOn !== null;
    }

    /**
     * @return DateTime|null
     */
    public function getUpdatedOn(): ?DateTime
    {
        return $this->updatedOn;
    }

    /**
     * @param DateTime $updatedOn
     */
    public function setUpdatedOn(DateTime $updatedOn): void
    {
        $this->updatedOn = $updatedOn;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }

    /**
     * @return DateTime|null
     */
    public function getDueDate(): ?DateTime
    {
        return $this->dueDate;
    }

    /**
     * @return bool
     */
    public function hasDueDate(): bool
    {
        return $this->dueDate !== null;
    }

    /**
     * @param DateTime $dueDate
     */
    public function setDueDate(DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @return AdditionalCosts|null
     */
    public function getAdditionalCosts(): ?AdditionalCosts
    {
        /** @var CustomField[] $res */
        $res = array_filter($this->customFields, function (CustomField $customField) {
            return $customField->getId() === self::ADDITIONAL_COSTS_ID;
        });

        if (count($res) === 1) {
            return new AdditionalCosts(array_pop($res));
        }

        return null;
    }

    /**
     * @return bool
     */
    public function getAdditionalCostsValue(): bool
    {
        $additionalCosts = $this->getAdditionalCosts();
        if ($additionalCosts !== null) {
            return $additionalCosts->getValue();
        }

        return false;
    }

    /**
     * @return ClientAvailable|null
     */
    public function getClientAvailable(): ?ClientAvailable
    {
        /** @var CustomField[] $res */
        $res = array_filter($this->customFields, function (CustomField $customField) {
            return $customField->getId() === self::CLIENT_AVAILABLE_ID;
        });

        if (count($res) === 1) {
            return new ClientAvailable(array_pop($res));
        }

        return null;
    }

    /**
     * @return bool
     */
    public function getClientAvailableValue(): bool
    {
        $clientAvailable = $this->getClientAvailable();
        if ($clientAvailable !== null) {
            return $clientAvailable->getValue();
        }

        return false;
    }

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->project->getId();
    }

    /**
     * @return int
     */
    public function getTrackerId(): int
    {
        return $this->tracker->getId();
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->status->getId();
    }

    /**
     * @return int
     */
    public function getPriorityId(): int
    {
        return $this->priority->getId();
    }

    /**
     * @return int|null
     */
    public function getAssignedToId(): ?int
    {
        return $this->assignedTo !== null ? $this->assignedTo->getId() : null;
    }
}
