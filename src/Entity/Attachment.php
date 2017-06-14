<?php
declare(strict_types=1);

namespace Appio\Redmine\Entity;

use Appio\Redmine\Util\CheckAttributeKeyUtil;

/**
 */
class Attachment
{
    const ID_KEY = 'id';

    const FILENAME_KEY = 'filename';

    const FILESIZE_KEY = 'filesize';

    const CONTENT_TYPE_KEY = 'content_type';

    const DESCRIPTION_KEY = 'description';

    const CONTENT_URL_KEY = 'content_url';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var int
     */
    private $filesize;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $contentUrl;

    /**
     * @var User
     */
    private $author;

    /**
     * @param int $id
     * @param string $filename
     * @param int $filesize
     * @param string $description
     * @param string $contentUrl
     * @param User $author
     */
    public function __construct(
        int $id,
        string $filename,
        int $filesize,
        string $description,
        string $contentUrl,
        User $author
    ) {
        $this->id = $id;
        $this->filename = $filename;
        $this->filesize = $filesize;
        $this->description = $description;
        $this->contentUrl = $contentUrl;
        $this->author = $author;
    }

    /**
     * @param array $data
     * @param User $author
     * @return Attachment
     * @throws \InvalidArgumentException
     */
    public static function createFromArray(array $data, User $author): Attachment
    {
        CheckAttributeKeyUtil::checkKeys(
            $data,
            [self::ID_KEY, self::FILENAME_KEY, self::FILESIZE_KEY, self::CONTENT_URL_KEY]
        );

        return new self(
            $data[self::ID_KEY],
            $data[self::FILENAME_KEY],
            $data[self::FILESIZE_KEY],
            $data[self::DESCRIPTION_KEY],
            $data[self::CONTENT_URL_KEY],
            $author
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
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getFilesize(): int
    {
        return $this->filesize;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getContentUrl(): string
    {
        return $this->contentUrl;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }
}
