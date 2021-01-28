<?php

declare(strict_types = 1);

namespace NamingThings;

class Noun
{
    private string $name;

    private string $description;

    /**
     * @var string[]
     */
    private array $also;

    /**
     *
     * @param string $name
     * @param string $description
     * @param string[] $also
     */
    public function __construct(
        string $name,
        string $description,
        array $also = []
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->also = $also;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAlso(): array
    {
        return $this->also;
    }
}
