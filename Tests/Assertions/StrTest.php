<?php

namespace Tests\Assertions;

use AssertionError;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Assertions\Str\assert_string_equal;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should assert two strings are equal',
    case: function () {
        assert_string_equal('foo', 'foo');

        try {
            assert_string_equal('foo', 'bar', 'foo is not equal to bar');
            assert_true(false, 'assert_string_equal is not working properly!');
        } catch (AssertionError $exception) {
            assert_true('foo is not equal to bar' === $exception->getMessage(), 'assert_string_equal message is not working');
        }
    }
);

test(
    title: 'it should return a default message for assert_string_equal',
    case: function () {
        try {
            assert_string_equal('foo', 'bar');
            assert_true(false, 'assert_string_equal is not working properly!');
        } catch (AssertionError $exception) {
            assert_true('bar is not equal to foo.' === $exception->getMessage(), 'assert_string_equal message is not working');
        }
    }
);
