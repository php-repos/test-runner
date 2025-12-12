<?php

namespace PhpRepos\TestRunner\Runner;

use AssertionError;
use Closure;
use PhpRepos\TestRunner\TestResults;
use ReflectionFunction;

function test(string $title, Closure $case, ?Closure $before = null, ?Closure $after = null, ?Closure $finally = null): void
{
    $test_run = TestResults\find(getenv('TEST_RESULT_ID'));

    // Add case with start time when test starts
    TestResults\save($test_run->add($title));

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

        // Update case with success status and finish time
        TestResults\save($test_run->update_case($title, true));
    } catch (AssertionError $exception) {
        // Update case with failure status and finish time
        TestResults\save($test_run->update_case($title, false));
    } catch (\Throwable $exception) {
        // Catch any other exception/error and mark as failed
        TestResults\save($test_run->update_case($title, false));
        // Re-throw to let the process handle it
        throw $exception;
    } finally {
        if ($finally) {
            call_user_func($finally);
        }
    }
}
