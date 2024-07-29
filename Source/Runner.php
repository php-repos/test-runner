<?php

namespace PhpRepos\TestRunner\Runner;

use AssertionError;
use Closure;
use PhpRepos\TestRunner\Statistics;
use ReflectionFunction;
use function PhpRepos\Cli\Output\error;
use function PhpRepos\Cli\Output\line;

function test(string $title, Closure $case, ?Closure $before = null, ?Closure $after = null, ?Closure $finally = null): void
{
    /** @var Statistics $statistics */
    $statistics = unserialize(file_get_contents(getenv('STATISTICS_STORAGE')));

    $statistics->cases++;

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
        $statistics->success++;
        line("✅ $title");
    } catch (AssertionError $exception) {
        $statistics->failed++;
        line("❌ $title: ");
        error($exception->getMessage());
    } finally {
        if ($finally) {
            call_user_func($finally);
        }

        file_put_contents(getenv('STATISTICS_STORAGE'), serialize($statistics));
    }
}
