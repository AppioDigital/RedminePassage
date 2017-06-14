<?php
declare(strict_types=1);

namespace Appio\Redmine\Uri;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 */
abstract class Uri implements UriInterface
{
    /** @var string */
    private $class;

    /** @var string */
    private $uri;

    /** @var array */
    private $params;

    /**
     * @param string $class
     * @param string $uri
     * @param array $params
     */
    public function __construct(string $class, string $uri, array $params = [])
    {
        $this->class = $class;
        $this->uri = $uri;
        $this->params = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * {@inheritdoc}
     */
    public function hasIdGetter(): bool
    {
        return method_exists($this->class, 'getId');
    }

    /**
     * {@inheritdoc}
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        $params = http_build_query(array_merge($this->getDefaultParams(), $this->params));

        return $params ? "$this->uri?$params" : $this->uri;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function getDenormalizer(): DenormalizerInterface;

    /**
     * @return array
     */
    protected function getDefaultParams(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->getUri();
    }
}
