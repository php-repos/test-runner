<?php

namespace Tests\FinallyHookTest;

use AssertionError;
use function PhpRepos\Cli\IO\Write\success;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should call finally hook for success',
    case: function () {
        assert_true(true);
        try {
            assert_true(false, 'failed message');
        } catch (AssertionError $exception) {
            assert_true('failed message' === $exception->getMessage());
        }
    },
    finally: function () {
        success('if you see this message, the finally hook is working.');
    }
);
