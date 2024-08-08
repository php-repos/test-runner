<?php

namespace PhpRepos\TestRunner;

use DateTimeImmutable;

abstract class Document
{
    public static string $storage = __DIR__ . '/../Storage/';
    public readonly string $collection;
    public readonly string $id;
    public readonly DateTimeImmutable $created_at;
    /**
     * TODO: When the lowest supported version is 8.3, make the property to be readonly
     */
    public DateTimeImmutable $updated_at;
    /**
     * TODO: When the lowest supported version is 8.3, make the property to be readonly
     */
    public int $version;

    public function init(): static
    {
        return $this->checkout(
            id: self::generate_UUID4(),
            created_at: new DateTimeImmutable('now'),
            updated_at: new DateTimeImmutable('now'),
            version: 1
        );
    }

    public function checkout(string $id, DateTimeImmutable $created_at, DateTimeImmutable $updated_at, int $version): static
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->version = $version;

        return $this;
    }

    public function update(): static
    {
        return clone $this;
    }

    public function __clone(): void
    {
        $this->updated_at = new DateTimeImmutable('now');
        $this->version++;
    }

    private static function generate_UUID4() {
        $data = random_bytes(16); // Generates 16 random bytes

        // Set version to 0100 (UUIDv4)
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set the two most significant bits to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Convert binary data to hexadecimal format
        return sprintf('%08s-%04s-%04s-%04s-%12s',
            bin2hex(substr($data, 0, 4)),
            bin2hex(substr($data, 4, 2)),
            bin2hex(substr($data, 6, 2)),
            bin2hex(substr($data, 8, 2)),
            bin2hex(substr($data, 10, 6))
        );
    }
}
