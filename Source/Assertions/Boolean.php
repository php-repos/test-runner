<?php

namespace PhpRepos\TestRunner\Assertions\Boolean;

use AssertionError;

function assert_false(bool $actual, ?string $message = null): bool
{
    $message = $message ?? 'true is not false.';

    return assert_true(! $actual, $message);
}

function assert_true(bool $actual, ?string $message = null): bool
{
    $message = $message ?? 'false is not true.';

    return $actual === true || throw new AssertionError($message);
}
