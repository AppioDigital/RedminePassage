<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Exception;
use Appio\Redmine\Entity\IssueProject;
use Appio\Redmine\Entity\Project;
use Appio\Redmine\Exception\EntityNotFoundException;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Fetcher\ObjectFetcher;
use Appio\Redmine\Normalizer\Entity\ProjectNormalizer;
use Appio\Redmine\Uri\ProjectUri;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

/**
 */
class ProjectManager
{
    /** @var ObjectFetcher */
    private $fetcher;

    /** @var ProjectNormalizer */
    private $denormalizer;

    /** @var Project */
    private $project;

    /** @var IssueProject */
    private $issueProject;

    /** @var int */
    private $id;

    /**
     * ProjectManager constructor.
     * @param ObjectFetcher $fetcher
     * @param ProjectNormalizer $denormalizer
     * @param $id
     */
    public function __construct(ObjectFetcher $fetcher, ProjectNormalizer $denormalizer, $id)
    {
        $this->fetcher = $fetcher;
        $this->id = $id;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @param array $options
     * @return IssueProject
     * @throws EntityNotFoundException
     */
    public function getIssueProject(array $options = []): IssueProject
    {
        $this->fetchProject($options);
        if ($this->issueProject === null) {
            $this->issueProject = $this->project->createIssueProject();
        }

        return $this->issueProject;
    }

    /**
     * @param array $options
     * @return string
     * @throws EntityNotFoundException
     */
    public function getName(array $options = []): string
    {
        $this->fetchProject($options);

        return $this->project->getName();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Fetches the project from redmine.
     * @param array $options
     * @throws EntityNotFoundException
     */
    private function fetchProject(array $options = []): void
    {
        try {
            if ($this->project === null) {
                $this->project = $this->fetcher->fetch(new ProjectUri($this->id, $this->denormalizer), $options);
            }
        } catch (ResponseException | UnexpectedValueException $exception) {
            throw new EntityNotFoundException(
                sprintf('Project with id "%d" was not found.', $this->id),
                $exception
            );
        } catch (Exception $exception) {
            throw new EntityNotFoundException(
                sprintf('There was some error when fetching project with id "%d".', $this->id),
                $exception
            );
        }
    }
}
