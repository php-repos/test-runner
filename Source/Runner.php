<?php

namespace PhpRepos\TestRunner\Runner;

use AssertionError;
use Closure;
use PhpRepos\TestRunner\TestResults;
use ReflectionFunction;

function test(string $title, Closure $case, ?Closure $before = null, ?Closure $after = null, ?Closure $finally = null): void
{
    $custom_pipe = fopen('php://fd/3', 'w');
    $test_run = TestResults\find(getenv('TEST_RESULT_ID'));

    try {
        $before_hook_output = $before ? call_user_func($before) : null;

        $reflection = new ReflectionFunction($case);
        if ($reflection->getNumberOfParameters() > 1) {
            $case_output = call_user_func($case, ...$before_hook_output);
        } else {
            $case_output = call_user_func($case, $before_hook_output);
        }

        $before_inputs = $case_output ?? $before_hook_output;

        if ($after) {
            $reflection = new ReflectionFunction($after);
            if ($reflection->getNumberOfParameters() > 1) {
                call_user_func($after, ...$before_inputs);
            } else {
                call_user_func($after, $before_inputs);
            }
        }

        TestResults\save($test_run->add_case($title, true));
        fwrite($custom_pipe, "✅ $title" . PHP_EOL);
    } catch (AssertionError $exception) {
        fwrite($custom_pipe, "❌ $title: " . PHP_EOL . $exception->getMessage() . PHP_EOL);
        TestResults\save($test_run->add_case($title, false));
    } finally {
        if ($finally) {
            call_user_func($finally);
        }

        fclose($custom_pipe);
    }
}
