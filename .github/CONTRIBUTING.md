# Contributing

## Setting up the development environment

To contribute to Test Runner, follow these steps:

1. Clone the repository:

    ```bash
    git clone git@github.com:php-repos/test-runner.git
    cd test-runner
    ```

2. Installing dependencies

    ```bash
    phpkg install
    ```

3. Building the project

    ```bash
    phpkg build
    # Or, for continuous development:
    phpkg watch
    ```

4. Running tests

   To test your changes:

    ```bash
    cd builds/development
    ./run
    ```