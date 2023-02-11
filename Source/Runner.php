<?php

namespace PhpRepos\TestRunner\Runner;

use AssertionError;
use Closure;
use ReflectionFunction;
use function PhpRepos\Cli\IO\Write\error;
use function PhpRepos\Cli\IO\Write\line;

function test(string $title, Closure $case, ?Closure $before = null, ?Closure $after = null, ?Closure $finally = null): void
{
    global $statistics;

    $statistics['cases']++;

    try {
        $beforeHookOutput = $before ? call_user_func($before) : null;

        $reflection = new ReflectionFunction($case);
        if ($reflection->getNumberOfParameters() > 1) {
            $caseOutput = call_user_func($case, ...$beforeHookOutput);
        } else {
            $caseOutput = call_user_func($case, $beforeHookOutput);
        }

        if ($after) {
            $reflection = new ReflectionFunction($after);
            if ($reflection->getNumberOfParameters() > 1) {
                call_user_func($after, ...$caseOutput);
            } else {
                call_user_func($after, $caseOutput);
            }
        }
        $statistics['success']++;
        line("✅ $title");
    } catch (AssertionError $exception) {
        $statistics['failed']++;
        line("❌ $title: ");
        error($exception->getMessage());
    } finally {
        if ($finally) {
            call_user_func($finally);
        }
    }
}
