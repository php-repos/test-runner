<?php

namespace Tests\FailTest;

use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should fail the test case',
    case: function () {
        assert_true(false, 'If you see this message, it means test runner is working as expected!');
    },
);
