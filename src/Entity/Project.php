<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Project
{
    const ID_KEY = 'id';

    const IDENTIFIER_KEY = 'identifier';

    const NAME_KEY = 'name';

    const DESCRIPTION_KEY = 'description';

    const STATUS_KEY = 'status';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $status;

    /**
     * Project constructor.
     * @param int $id
     * @param string $identifier
     * @param string $name
     */
    private function __construct(int $id, string $identifier, string $name)
    {
        $this->id = $id;
        $this->identifier = $identifier;
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * Creates a project instance from array.
     *
     * @param array $arrayProject
     * @return Project
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $arrayProject): Project
    {
        CheckAttributeKeyUtil::checkKeys(
            $arrayProject,
            [self::ID_KEY, self::IDENTIFIER_KEY, self::NAME_KEY, self::STATUS_KEY, self::DESCRIPTION_KEY]
        );

        $project = new self(
            $arrayProject[self::ID_KEY],
            $arrayProject[self::IDENTIFIER_KEY],
            $arrayProject[self::NAME_KEY]
        );
        $project->setStatus($arrayProject[self::STATUS_KEY]);
        $project->setDescription($arrayProject[self::DESCRIPTION_KEY]);

        return $project;
    }

    /**
     * Creates IssueProject instance.
     * @return IssueProject
     */
    public function createIssueProject(): IssueProject
    {
        return new IssueProject($this->id, $this->name);
    }
}
