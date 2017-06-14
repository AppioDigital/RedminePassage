<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Appio\Redmine\Entity\User;
use Appio\Redmine\Exception\EntityNotFoundException;

/**
 */
class UserManager
{
    /**
     * @var User[]
     */
    private $users;

    /**
     * UserManager constructor.
     */
    public function __construct()
    {
        $this->users = [];
    }

    /**
     * @param User $user
     */
    public function addUser(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function get($id): User
    {
        if ($this->userExists($id)) {
            return $this->users[$id];
        }
        throw new EntityNotFoundException(sprintf('User with id "%d" doesn\'t exist.', $id));
    }

    /**
     * @param int $id
     * @return bool
     */
    public function userExists($id): bool
    {
        return array_key_exists($id, $this->users);
    }
}
