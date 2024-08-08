<?php

namespace Tests\RunTest;

use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should run tests in given directory',
    case: function () {
        exec('php ' . getcwd() . DIRECTORY_SEPARATOR . 'run --directory=OtherTestDirectory', $output);

        assert_true(str_contains($output[0], "✅ it should pass the test case"));
        assert_true(3 === count($output));
    },
);
