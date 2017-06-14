<?php
declare(strict_types=1);

namespace Appio\Redmine\Manager;

use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Appio\Redmine\Entity\Upload;
use Appio\Redmine\Exception\ResponseException;
use Appio\Redmine\Normalizer\Entity\UploadNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 */
class UploadManager
{
    /** @var HttpClient */
    private $client;

    /** @var MessageFactory */
    private $messageFactory;

    /** @var JsonEncoder */
    private $decoder;

    /** @var UploadNormalizer */
    private $denormalizer;

    /**
     * @param JsonEncoder $decoder
     * @param UploadNormalizer $denormalizer
     * @param HttpClient $client
     * @param MessageFactory $messageFactory
     */
    public function __construct(
        JsonEncoder $decoder,
        UploadNormalizer $denormalizer,
        HttpClient $client,
        MessageFactory $messageFactory
    ) {
        $this->decoder = $decoder;
        $this->denormalizer = $denormalizer;
        $this->client = $client;
        $this->messageFactory = $messageFactory;
    }

    /**
     * @param string $filePath
     * @param string $clientFileName
     * @param string $contentType
     * @param string $description
     * @param array $options
     * @return Upload
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Serializer\Exception\UnexpectedValueException
     * @throws ResponseException
     */
    public function create(
        string $filePath,
        string $clientFileName,
        string $contentType,
        string $description = '',
        array $options = []
    ): Upload {
        $clientOptions = $options;
        $clientOptions['Content-Type'] = 'application/octet-stream';

        $request = $this->messageFactory->createRequest(
            'POST',
            'uploads.json',
            $clientOptions,
            file_get_contents($filePath)
        );

        try {
            $response = $this->client->sendRequest($request);
        } catch (\Exception $exception) {
            throw new ResponseException($exception->getMessage(), $exception->getCode());
        }

        if ($response->getStatusCode() !== 201) {
            throw new ResponseException((string) $response->getBody(), $response->getStatusCode());
        }

        $decoded = $this->decoder->decode($response->getBody(), 'json');
        $upload = $this->denormalizer->denormalize($decoded, Upload::class, 'json');
        $upload->setFileName($clientFileName);
        $upload->setDescription($description);

        if ($contentType) {
            $upload->setContentType($contentType);
        } else {
            $upload->setContentType(\mime_content_type($filePath));
        }

        return $upload;
    }
}
