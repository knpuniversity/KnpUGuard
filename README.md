# KnpGuardPlugin

Add simple and beautiful authentication to your Symfony project.

[![Build Status](https://travis-ci.org/knpuniversity/KnpUGuardBundle.svg?branch=master)](https://travis-ci.org/knpuniversity/KnpUGuardBundle)

This is a library is usable, but is *alpha*, and backwards compatibility
is not guaranteed yet. The original purpose was to get feedback and use-cases
from people so that we can merge this feature into Symfony itself
(see [symfony/symfony#14673](https://github.com/symfony/symfony/pull/14673)).

## Installation

**This bundle requires Symfony 2.6 or higher.**

First, wave your [composer](https://getcomposer.org/) wand to install things:

```bash
composer require knpuniversity/guard-bundle:dev-master
```

Next, plug the bundle into your `app/AppKernel.php` file:

```php
    public function registerBundles()
    {
        $bundles = array(
            // -> add just this ONE line
            new KnpU\GuardBundle\KnpUGuardBundle(),
        );

        // ...
    }
```

Now, start using it!

## Usage

For an example application, see [knpuniversity/symfony-guard-demo](https://github.com/knpuniversity/symfony-guard-demo).

Whether you want to authenticate via a form login, by reading an API token
or both, you'll follow the same 3-step process:

### 1) Create an Authenticator class

Each time you want to authenticate a user, you'll start by creating a class
that extends [KnpU\GuardBundle\Guard\AbstractGuardAuthenticator](https://github.com/knpuniversity/KnpUGuardBundle/blob/master/Guard/AbstractGuardAuthenticator.php)
(or implements [KnpU\GuardBundle\Guard\GuardAuthenticatorInterface](https://github.com/knpuniversity/KnpUGuardBundle/blob/master/Guard/GuardAuthenticatorInterface.php)).
For examples, see [TokenAuthenticator](https://github.com/knpuniversity/symfony-guard-demo/blob/master/src/AppBundle/Security/TokenAuthenticator.php)
and [FormLoginAuthenticator](https://github.com/knpuniversity/symfony-guard-demo/blob/master/src/AppBundle/Security/FormLoginAuthenticator.php).

This interface has a method for every part of the authentication process,
from fetching the credentials (e.g. username/password or API token) from
the request to handling success and error situations.

### 2) Create a User Provider

A User Provider is basically a class that knows how to load your "users".
It's passed to the `getUser()` method of your authenticator. Whether you
are loading users from a database or elsewhere, I recommend creating your
own user provider class.

For example, see [UserProvider](https://github.com/knpuniversity/symfony-guard-demo/blob/master/src/AppBundle/Security/UserProvider.php)
from the demo project.

### 3) Register the authenticator (and user provider) as a service

The authenticators are plain old services, so this is easy. For example,

```yml
# app/config/services.yml
services:
    app.form_login_authenticator:
        class: AppBundle\Security\FormLoginAuthenticator
        arguments: ['@security.password_encoder', '@router']

    app.token_authenticator:
        class: AppBundle\Security\TokenAuthenticator
        arguments: []

   app.user_provider:
        class: AppBundle\Security\UserProvider
        arguments: ['@doctrine.orm.entity_manager']
```

### 4) Configure security.yml

For a full example `security.yml`, see [security.yml](https://github.com/knpuniversity/symfony-guard-demo/blob/master/app/config/security.yml)
in the demo app.

There are basically only two critical areas to configure: `providers`
and `firewalls`:

```yml
security:
    encoders:
        AppBundle\Entity\User: bcrypt

    providers:
        # the service id to your provider (you can also use other providers,
        # like the "entity" provider)
        main_provider:
            id: app.user_provider

    firewalls:
        secured_area:
            # this firewall applies to all URLs
            pattern: ^/
            anonymous: true

            knpu_guard:
                authenticators:
                    - app.form_login_authenticator
                    - app.token_authenticator
                # provider: main_provider

                # since you have 2 firewalls, you'll choose which "start"
                # method is called when the user should be asked to login
                # entry_point: app.token_authenticator
                entry_point: app.form_login_authenticator

            # any other keys, like remember_me, switch_user, logout, etc

    # ...
```

First, you'll register your user provider under the `providers` key. Next,
add a `knpu_guard` key under your firewall with an `authenticators` key.
Here, put the service ids of all your authenticators: you may have just one.

That's it! Your authenticators should be called on every request, and they
can authenticate to their heart's desire.
