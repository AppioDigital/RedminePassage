<?php
declare(strict_types=1);

namespace Appio\Redmine\Normalizer;

/**
 */
trait DenormalizerTrait
{
    /**
     * Returns data for denormalization for the given key.
     * The original data are returned if the key does not exist.
     *
     * @param array $data
     * @param string $objectKey
     * @return array
     */
    private function getObjectData(array $data, string $objectKey): array
    {
        if (array_key_exists($objectKey, $data) === true) {
            return $data[$objectKey];
        }

        return $data;
    }
}
