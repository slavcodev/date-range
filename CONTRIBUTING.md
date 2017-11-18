# Contributing guide

The contribution is accepted via Pull Requests

## Pull Requests

- **Follow the conventions used in the project.** - Fix the code style with `$ php-cs-fixer fix`.

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant documentation are kept up-to-date.

- **Consider our release cycle** - We try to follow [SemVer v2.0.0](http://semver.org/).
    Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask us to pull from your master branch, create branch, e.g. `feature-name` or `bugfix-title`.

- **One pull request per feature** - If you want to do more than one thing, send multiple pull requests. Use appropriate labels.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful.
    If you had to make multiple intermediate commits while developing, please [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages) before submitting.
    Please read [How to write a good Git commit messages](https://chris.beams.io/posts/git-commit/)


## Running Tests

~~~bash
$ phpunit
~~~


## Project's standards

 * [PSR-1: Basic Coding Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)
 * [PSR-2: Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
 * [PSR-4: Autoloading Standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
 * [PSR-5: PHPDoc (draft)](https://github.com/phpDocumentor/fig-standards/blob/master/proposed/phpdoc.md)
 * Keep the order of class elements: static properties, instance properties, constructor (or setUp for PHPUnit), destructor (or tearDown for PHPUnit), static methods, instance methods, magic static methods, magic instance methods.


**Enjoy coding**!
