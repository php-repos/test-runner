<?php

namespace Tests\SuccessTest;

use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should pass the test case',
    case: function () {
        assert(true, 'If you see this message, it means test runner is not working as expected!');
    },
);
