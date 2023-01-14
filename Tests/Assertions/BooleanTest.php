<?php

namespace Tests\Assertions\BooleanTest;

use AssertionError;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_false;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should assert true',
    case: function () {
        assert_true(true);
        try {
            assert_true(false, 'false is false not true');
            assert_true(false, 'assert_true for false is not working');
        } catch (AssertionError $exception) {
            assert_true('false is false not true' === $exception->getMessage(), 'assert_true message is not working');
        }
    }
);

test(
    title: 'it should assert false',
    case: function () {
        assert_false(false);
        try {
            assert_false(true, 'true is true not false');
            assert_true(false, 'assert_false for true is not working');
        } catch (AssertionError $exception) {
            assert_true('true is true not false' === $exception->getMessage(), 'assert_false message is not working');
        }
    }
);

test(
    title: 'it should use a default message for assert_true',
    case: function () {
        try {
            assert_true(false);
            assert_true(false, 'assert_true for true is not working');
        } catch (AssertionError $exception) {
            assert_true('false is not true.' === $exception->getMessage(), 'default message for assert_true is not working');
        }
    }
);

test(
    title: 'it should use a default message for assert_false',
    case: function () {
        try {
            assert_false(true);
            assert_true(false, 'assert_true for true is not working');
        } catch (AssertionError $exception) {
            assert_true('true is not false.' === $exception->getMessage(), 'default message for assert_false is not working');
        }
    }
);
