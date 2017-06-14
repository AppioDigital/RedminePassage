<?php
declare(strict_types=1);

namespace Appio\Redmine\Util;

/**
 */
final class CheckAttributeKeyUtil
{
    /**
     * @param array $data
     * @param string $key
     * @throws \InvalidArgumentException
     */
    private static function checkAttributeKey(array $data, string $key): void
    {
        if (array_key_exists($key, $data) === false) {
            throw new \InvalidArgumentException(sprintf('Key with name "%s" does not exist.', $key));
        }
    }

    /**
     * @param array $data
     * @param array $keys
     * @throws \InvalidArgumentException
     */
    public static function checkKeys(array $data, array $keys): void
    {
        foreach ($keys as $key) {
            self::checkAttributeKey($data, $key);
        }
    }
}
