# Contributing

## How to contribute

### Getting Started

1. Clone repository or your fork locally
1. Install sdk dependencies including _dev_ with the following command `composer install`
1. Check that the current tests pass with the following command `php vendor/bin/phpunit`

### Making Changes

1. Create feature branch
1. Make changes. Please make sure that you don't break backward compatibility
1. Add unit tests. Also add integration tests if needed
1. Add new section to [CHANGELOG.md](CHANGELOG.md) with clear description. Please follow [keepachangelog.com](http://keepachangelog.com/) guide.
1. Run `php vendor/bin/php-cs-fixer fix . --allow-risky=yes` before commit
1. Run tests before commit `php vendor/bin/phpunit`
1. Commit changes. Please use description of your patch from [CHANGELOG.md](CHANGELOG.md) for commit message.

### Submitting Changes

1. Push your changes to a feature branch
1. Submit a pull request
1. Assign pull request to [one of core team members](https://github.com/orgs/xsolla/people)

## Add new API command to client

1. Add new command to [guzzle3 service description config](http://guzzle3.readthedocs.org/webservice-client/guzzle-service-descriptions.html) in [src/API/Resources/api.php](src/API/Resources/api.php)
1. Add phpDocumentor DocBlocks with new methods to [src/API/XsollaClient.php](src/API/XsollaClient.php)
1. Add new tests to [tests/Integration/API/](tests/Integration/API/)

## Release a new version

### How to choose right version number

Version name should be in the following format **v**MAJOR.MINOR.PATCH

Please follow [semver.org](http://semver.org/) convention for new version choosing. 
If new changes don't contain new valuable features for end users or urgent bug fixes, then the new release is not needed.

### Release process

1. Merge all needed pull requests to master branch
   1. Change version in [src/Version.php](src/Version.php)
   1. Set new version number instead _Unreleased_ section name in [CHANGELOG.md](CHANGELOG.md). Add New _Unreleased_ section to top of the [CHANGELOG.md](CHANGELOG.md) file
1. Create tag with version "vMAJOR.MINOR.PATCH" and push it (tag must be linked to merge commit)
1. Review diff between new released version and master branch, include [CHANGELOG.md](CHANGELOG.md)
1. Create new release at github
    1. Create new release draft with version name
    1. Copy release description from changelog
    1. Run `php build/packager.php` locally
    1. Attach to release _xsolla.zip_, _xsolla.phar_ from [build/artifacts](build/artifacts)
