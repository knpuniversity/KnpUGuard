# KnpGuard

Add simple and beautiful authentication to Symfony's security component in Silex
and anywhere else.

[![Build Status](https://travis-ci.org/knpuniversity/KnpUGuard.svg?branch=master)](https://travis-ci.org/knpuniversity/KnpUGuard)

This is a library is usable, but is *alpha*, and backwards compatibility
is not guaranteed yet. The original purpose was to get feedback and use-cases
from people so that we can merge this feature into Symfony itself
(see [symfony/symfony#14673](https://github.com/symfony/symfony/pull/14673)).

## Documentation

Find a full tutorial here: https://knpuniversity.com/screencast/guard

## Basic Usage

Check out the [Tutorial](https://knpuniversity.com/screencast/guard) for real documentation.
But here's the basic idea.

Guard works by creating a single class - an **authenticator** - that handles *everything*
about how you want to authenticate your users. And authenticator implements
[KnpU\Guard\GuardAuthenticatorInterface](https://github.com/knpuniversity/KnpUGuard/blob/master/src/GuardAuthenticatorInterface.php))

Here are some real-world examples from the tutorial:

Goal                                        | Code                                                                                                                                          | Tutorial
------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------------- | -------
Authenticate by reading an `X-TOKEN` header | [ApiTokenAuthenticator.php](https://github.com/knpuniversity/guard-tutorial/blob/finished/src/AppBundle/Security/ApiTokenAuthenticator.php)   | [How to Authenticate via an API Token](https://knpuniversity.com/screencast/guard/api-token)
Form login authentication                   | [FormLoginAuthenticator.php](https://github.com/knpuniversity/guard-tutorial/blob/finished/src/AppBundle/Security/FormLoginAuthenticator.php) | [How to Create a Login Form](https://knpuniversity.com/screencast/guard/login-form)
Social Login (Facebook)                     | [FacebookAuthenticator.php](https://github.com/knpuniversity/guard-tutorial/blob/finished/src/AppBundle/Security/FacebookAuthenticator.php)   | [Social Login with Facebook](https://knpuniversity.com/screencast/guard/social-login)

## Contributing

Find a bug or a use-case that this doesn't support? [Open an Issue](https://github.com/knpuniversity/KnpUGuard/issues)
so we can make things better.

## License

This library is under the MIT license. See the complete license in the LICENSE file.
