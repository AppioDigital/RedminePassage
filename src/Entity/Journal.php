<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;
use DateTime;

/**
 */
class Journal
{
    const ID_KEY = 'id';

    const NOTES_KEY = 'notes';

    const PRIVATE_NOTES_KEY = 'private_notes';

    const CREATED_ON_KEY = 'created_on';

    /**
     * @var int
     */
    private $id;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var bool
     */
    private $privateNotes;

    /**
     * @var DateTime
     */
    private $createdOn;

    /**
     * @param int $id
     * @param string $notes
     * @param bool $privateNotes
     * @param DateTime $createdOn
     * @param User $user
     */
    public function __construct(int $id, string $notes, bool $privateNotes, DateTime $createdOn, User $user)
    {
        $this->id = $id;
        $this->user = $user;
        $this->notes = $notes;
        $this->privateNotes = $privateNotes;
        $this->createdOn = $createdOn;
    }

    /**
     * @param array $data
     * @param User $user
     * @return Journal
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data, User $user): Journal
    {
        CheckAttributeKeyUtil::checkKeys($data, [self::ID_KEY, self::NOTES_KEY, self::CREATED_ON_KEY]);

        return new self(
            $data[self::ID_KEY],
            $data[self::NOTES_KEY],
            $data[self::PRIVATE_NOTES_KEY] ?? false,
            new DateTime($data[self::CREATED_ON_KEY]),
            $user
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return $this->notes;
    }

    /**
     * @return bool
     */
    public function isPrivateNotes(): bool
    {
        return $this->privateNotes;
    }

    /**
     * @return DateTime
     */
    public function getCreatedOn(): DateTime
    {
        return $this->createdOn;
    }
}
