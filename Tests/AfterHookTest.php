<?php

namespace Tests\AfterHookTest;

use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should run the after hook for success tests',
    case: function () {
        assert_true(true);

        return 'foo';
    },
    after: function ($a) {
        assert_true($a === 'foo', 'After hook does not work properly!');
    }
);

test(
    title: 'it should unpack array data',
    case: function () {
        assert_true(true);
        $a = 'foo';
        $b = 'bar';

        return compact('a', 'b');
    },
    after: function ($a, $b) {
        assert_true($a === 'foo' && $b === 'bar', 'After hook does not work with array unpacking!');
    }
);

test(
    title: 'it should not unpack the array when after needs array in one parameter',
    case: function () {
        assert_true(true);
        $a = 'foo';
        $b = 'bar';

        return compact('a', 'b');
    },
    after: function ($array) {
        assert_true($array['a'] === 'foo' && $array['b'] === 'bar', 'After hook does not work with array return type!');
    }
);

test(
    title: 'it should not run the after hook for failed tests',
    case: function () {
        assert_true(false === true, 'If you see me, it means everything is working fine ;)');

        $a = 'foo';
        $b = 'bar';

        return compact('a', 'b');
    },
    after: function () {
        assert_true(false === true, 'You should not be here! After hook should not run for failed tests.');
    }
);
