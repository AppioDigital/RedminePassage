<?php
declare(strict_types=1);

namespace Appio\Redmine\Exception;

/**
 */
class EntityNotFoundException extends \RuntimeException
{
    /**
     * EntityNotFoundException constructor.
     * @param string $message
     * @param \Exception|null $previous
     */
    public function __construct(string $message, \Exception $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
