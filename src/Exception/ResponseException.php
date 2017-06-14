<?php
declare(strict_types=1);

namespace Appio\Redmine\Exception;

/**
 */
class ResponseException extends \RuntimeException
{
    /**
     * ResponseException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message, int $code, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
