# PhpRepos Test Runner Package

## Introduction

PhpRepos Test Runner Package is a simple solution to define and run tests for a PHP library.

## Installation

You can simply install this package using `phpkg` by running the following command:

```shell
phpkg add git@github.com:php-repos/test-runner.git
```

## Documentation

All documents can be found under [documentations](https://phpkg.com/packages/test-runner/documentations/getting-started)

## Contributing

Run following commands to prepare the test runner:

```shell
git clone git@github.com:php-repos/test-runner.git
cd test-runner
phpkg install
phpkg build // or watch while you are developing
```

For running tests:

```shell
cd builds/development
./run
```
