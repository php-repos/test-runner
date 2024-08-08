<?php

namespace PhpRepos\TestRunner;

class TestRun extends Document
{
    public function __construct(
        public readonly string $path,
        public readonly string $filter,
        public ?array $cases = [],
    ) {}

    public function add_case(string $title, bool $successful): static
    {
        $this->cases[] = ['title' => $title, 'successful' => $successful];

        return $this->update();
    }
}
