<?php

namespace Tests\SuccessTest;

use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should pass the test case',
    case: function () {
        assert_true(true, 'If you see this message, it means test runner is not working as expected!');
    },
);
