# KnpGuard

Add simple and beautiful authentication to Symfony's security component in Silex
and anywhere else.

[![Build Status](https://travis-ci.org/knpuniversity/KnpUGuard.svg?branch=master)](https://travis-ci.org/knpuniversity/KnpUGuard)

**This library is *deprecated* since Symfony 2.8 and won't work with Symfony 3.**

The original purpose was to get feedback and use-cases from people so that we can merge this feature into Symfony itself
(see [symfony/symfony#14673](https://github.com/symfony/symfony/pull/14673)).

Now it's good (see [news from Symfony](http://symfony.com/blog/new-in-symfony-2-8-guard-authentication-component)).

## Upgrade to Symfony 3

On Symfony 2.8, use the official [Guard component](https://symfony.com/doc/master/cookbook/security/guard-authentication.html).

### Step 1 - Remove the library from your composer.json

Be sure to be on Symfony 2.8, open `composer.json` file and remove the library:

Before:
```json
{
    "require": {
        "php": ">=5.5",
        "symfony/symfony": "~2.8",
        "...": "...",
        "knpuniversity/guard-bundle": "~0.1@dev"
    },
}
```

Now:
```json
{
    "require": {
        "php": ">=5.5",
        "symfony/symfony": "~2.8",
        "...": "..."
    },
}
```

### Step 2 - Remove it from your AppKernel

If you're using the Symfony framework, remove the KnpUGuardBundle from `AppKernel.php`.

### Step 3 - Modify firewall(s)

Open and modify `security.yml` file, replace in your firewall(s) key(s) `knpu_guard` by `guard`:

Before:
```yaml
# app/config/security.yml
security:
    # ...

    firewalls:
        # ...

        main:
            anonymous: ~
            logout: ~

            knpu_guard:
                authenticators:
                    - app.form_login_authenticator

            # maybe other things, like form_login, remember_me, etc
            # ...
```

Now:
```yaml
# app/config/security.yml
security:
    # ...

    firewalls:
        # ...

        main:
            anonymous: ~
            logout: ~

            guard:
                authenticators:
                    - app.form_login_authenticator

            # maybe other things, like form_login, remember_me, etc
            # ...
```

### Step 4 - Update Authenticator(s)

Update uses in Authenticator(s) class(es).

**Warning:** checkCredentials() NOW must return true in order for authentication to be successful. 
In KnpUGuard, if you did NOT throw an AuthenticationException, it would pass.

Before:
```php
use KnpU\Guard\Authenticator\AbstractFormLoginAuthenticator;
use KnpU\Guard\...;
// ...

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    // ...

    public function checkCredentials($credentials, UserInterface $user)
    {
        // ...
        
        if ($password !== 'correctPassword') {
            throw new AuthenticationException();
        }

        // do nothing, allow authentication to pass
    }

    // ...
}
```

Now:
```php
use Symfony\Component\Security\Guard\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\...;
// ...

class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    // ...

    public function checkCredentials($credentials, UserInterface $user)
    {
        // ...
        
        if ($password !== 'correctPassword') {
            // returning anything NOT true will cause an authentication failure
            return;
            // or, you can still throw an AuthenticationException if you want to
            // throw new AuthenticationException();
        }

        // return true to make authentication successful
        return true;
    }

    // ...
}
```

### Step 5 - Yes we can test it

That's it! Try it out, and then upgrade to Symfony 3 :).

- [http://symfony.com/doc/current/cookbook/upgrade/major_version.html](http://symfony.com/doc/current/cookbook/upgrade/major_version.html)

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
