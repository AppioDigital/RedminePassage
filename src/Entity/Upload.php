<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Upload
{
    const TOKEN_KEY = 'token';

    const FILENAME_KEY = 'filename';

    const CONTENT_TYPE_KEY = 'content_type';

    const DESCRIPTION_KEY = 'description';

    /** @var string */
    private $token;

    /** @var string|null */
    private $fileName;

    /** @var string|null */
    private $contentType;

    /** @var string|null */
    private $description;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @param array $data
     * @return Upload
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data): Upload
    {
        CheckAttributeKeyUtil::checkKeys($data, [self::TOKEN_KEY]);
        return new self($data[self::TOKEN_KEY]);
    }

    /**
     * @param string $fileName
     */
    public function setFileName(string $fileName): void
    {
        $this->fileName = $fileName;
    }

    /**
     * @param string $contentType
     */
    public function setContentType(string $contentType): void
    {
        $this->contentType = $contentType;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        $result[self::TOKEN_KEY] = $this->token;

        if ($this->fileName !== null) {
            $result[self::FILENAME_KEY] = $this->fileName;
        }

        if ($this->contentType !== null) {
            $result[self::CONTENT_TYPE_KEY] = $this->contentType;
        }

        if ($this->description !== null) {
            $result[self::DESCRIPTION_KEY] = $this->description;
        }

        return $result;
    }
}
