<?php

namespace PhpRepos\TestRunner;

class TestRun extends Document
{
    public function __construct(
        public readonly string $path,
        public readonly string $filter,
        public ?array $cases = [],
    ) {}

    public function add(string $title): static
    {
        $this->cases[] = [
            'title' => $title,
            'started_at' => microtime(true),
        ];

        return $this->update();
    }

    public function update_case(string $title, bool $successful): static
    {
        foreach ($this->cases as &$case) {
            if ($case['title'] === $title && !isset($case['finished_at'])) {
                $case['successful'] = $successful;
                $case['finished_at'] = microtime(true);
                break;
            }
        }

        return $this->update();
    }
}
