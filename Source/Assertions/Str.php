<?php

namespace PhpRepos\TestRunner\Assertions\Str;

use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;

function assert_string_equal(string $expected, string $actual, ?string $message = null): bool
{
    $message = $message ?? "$actual is not equal to $expected.";

    return assert_true($expected === $actual, $message);
}
