<?php

namespace Tests\RegularFile;

use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test('it loads regular files', function () {
    assert_true(true);
});

// This function has been used in different test case
function returnTrue()
{
    return true;
}
