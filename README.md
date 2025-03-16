# Test Runner Package

## Introduction

Test Runner Package is a simple solution to define and run tests for a PHP library, best used as a standalone tool via `phpkg run` or, if necessary, as a project dependency.

---

## Running tests as a tool

Before you consider adding Test Runner as a dependency to your project, we strongly recommend using it as a standalone tool via the `phpkg run` command. Here’s why:

- **No clutter in your project**: Adding it as a dependency increases your project's footprint and introduces unnecessary files into your dependency tree.
- **Simpler workflow**: Using `phpkg run` lets you leverage Test Runner without modifying your project’s configuration or requiring installation steps.
- **Up-to-date usage**: Running it directly ensures you’re always using the latest version without needing to update your `phpkg` dependencies manually.

For a detailed explanation of why avoiding dev dependencies can benefit your workflow, check out [this Medium article](https://medium.com/@MortezaPoussane/stop-adding-tools-as-dependencies-52aac4a9468c).

To use Test Runner without installation, simply build your project and run it like this:

```bash
phpkg build
cd builds/development
phpkg run https://github.com/php-repos/test-runner.git
```

This method requires no installation and enables immediate testing.

> Note: When using Test Runner as a tool, your IDE might not resolve PhpRepos\TestRunner\Runner\test or PhpRepos\TestRunner\Assertions. This won’t affect execution, as Test Runner loads these definitions at runtime. IDE extensions to resolve these are in development.

## As a dependency by installation (only if you must)

If you still prefer to install Test Runner as a dependency, you can do so with:

```shell
phpkg add https://github.com/php-repos/test-runner.git
```

Then you can run tests:

```bash
phpkg build
cd builds/development
./test-runner
```

The Test Runner file is executable and requires no `php` prefix.

## Writing tests

By default, Test Runner looks for tests in the `Tests` directory of your project. Test files must end with `Test.php` (e.g., `HomeTest.php`) to be recognized.

### Defining tests

Define tests using the test function, which has the following signature:

```php
use function PhpRepos\TestRunner\Runner\test;

function test(string $title, Closure $case, ?Closure $before = null, ?Closure $after = null, ?Closure $finally = null)
```

Here’s what each parameter does:

- `title`: The test’s name, displayed in the output when running tests.
- `case`: A closure containing the main test logic.
- `before`: (Optional) A closure executed before the test case, useful for setup.
- `after`: (Optional) A closure executed after a successful test case, ideal for cleanup.
- `finally`: (Optional) A closure that runs after the test case, even if it fails.

#### Example: Basic Test

```php
use function PhpRepos\TestRunner\Assertions\assert_true;
use function PhpRepos\TestRunner\Assertions\assert_false;
use function PhpRepos\TestRunner\Runner\test;

test(
    title: 'it should return true when the string starts with the given substring',
    case: function () {
        assert_true(str_starts_with('Hello World', 'Hello'));
        assert_false(str_starts_with('Hello World', 'World'));
    }
);
```

#### Example: Using before

Set up preconditions before the test:

```php
test(
    title: 'it should assert directory exists',
    case: function () {
        assert_true(file_exists(__DIR__ . '/TestDirectory'));
    },
    before: function () {
        mkdir(__DIR__ . '/TestDirectory');
    }
);
```

Pass variables from before to case:

```php
test(
    title: 'it should assert directory exists',
    case: function ($directory) {
        assert_true(file_exists($directory));
    },
    before: function () {
        $directory = __DIR__ . '/TestDirectory';
        mkdir($directory);
        return $directory;
    }
);
```

Return multiple values as an array:

```php
test(
    title: 'it should assert directory and file exist',
    case: function ($directory, $file) {
        assert_true(file_exists($directory));
        assert_true(file_exists($file));
    },
    before: function () {
        $directory = __DIR__ . '/TestDirectory';
        mkdir($directory);
        $file = $directory . '/filename';
        file_put_contents($file, 'file content');
        return [$directory, $file];
    }
);
```

#### Example: Using after

Clean up after a successful test:

```php
test(
    title: 'it should assert directory exists',
    case: function () {
        assert_true(file_exists(__DIR__ . '/TestDirectory'));
    },
    before: function () {
        mkdir(__DIR__ . '/TestDirectory');
    },
    after: function () {
        rmdir(__DIR__ . '/TestDirectory');
    }
);
```

Pass variables from case to after:

```php
test(
    title: 'it should assert directory exists',
    case: function ($directory) {
        assert_true(file_exists($directory));
        return $directory;
    },
    before: function () {
        $directory = __DIR__ . '/TestDirectory';
        mkdir($directory);
        return $directory;
    },
    after: function ($directory) {
        rmdir($directory);
    }
);
```

If case doesn’t return anything, before outputs go to after:

```php
test(
    title: 'it should pass data from before to after',
    case: function () {
        assert_true(true);
    },
    before: function () {
        $directory = __DIR__ . '/TestDirectory';
        mkdir($directory);
        return $directory;
    },
    after: function ($directory) {
        rmdir($directory);
    }
);
```

#### Example: Using finally

Run code regardless of test success or failure:

```php
test(
    title: 'it should assert directory not exists',
    case: function () {
        assert_false(file_exists(__DIR__ . '/TestDirectory'));
    },
    before: function () {
        mkdir(__DIR__ . '/TestDirectory');
    },
    finally: function () {
        rmdir(__DIR__ . '/TestDirectory');
    }
);
```

> Note: You cannot pass parameters to the finally closure.
