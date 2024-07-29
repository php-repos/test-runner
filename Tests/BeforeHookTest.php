<?php

namespace Tests\BeforeHookTest;

use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should run the before hook',
    case: function ($variable) {
        assert_true($variable === 'This is a variable from before hook', 'before hook is not working properly');

        return 'foo';
    },
    before: function () {
        return 'This is a variable from before hook';
    }
);

test(
    title: 'it should unpack array data from before hook',
    case: function ($a, $b) {
        assert_true($a === 'foo' && $b === 'bar', 'Before hook does not work with array unpacking!');
    },
    before: function () {
        $a = 'foo';
        $b = 'bar';

        return compact('a', 'b');
    },
);

test(
    title: 'it should not unpack the array when before hook sends array in one parameter',
    case: function ($array) {
        assert_true($array['a'] === 'foo' && $array['b'] === 'bar', 'Before hook does not work with array return type!');
    },
    before: function () {
        $a = 'foo';
        $b = 'bar';

        return compact('a', 'b');
    }
);
