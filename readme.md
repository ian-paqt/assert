# PAQT.com Mail Interceptor
This package makes sure that the recipients of emails are replaced when not on a production environment.

# Installation

To get started, you should add the the repo as a valid repository to your `composer.json`
```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:paqtcom/laravel-mail-interceptor.git"
    }
]
```

Then you can install the `paqtcom/mail-interceptor` Composer dependency to your project:
```bash
composer require paqtcom/mail-interceptor
```
After installing the package, publish the config:
```bash
php artisan vendor:publish --provider="PAQT\MailInterceptor\ServiceProvider"
```
Finally, make sure the settings are correctly configured by editing `config/mail-interceptor.php`.

# Configuration

| Name                | Description                                                                      | Default value                        |
| ------------------- | -------------------------------------------------------------------------------- | ------------------------------------ |
| `replacement-email` | E-mail address that will be used to replace the recipient with when intercepted  | `assist+mail-interceptor@paqt.com` |
| `allowed-domains`   | Domains that are allowed and should not be intercepted                           | `[ '@paqt.com' ]`                  |
| `intercept`         | Main on/off switch controlling whether to enable or disable the mail interceptor | `true`                               |

## Environment variable

In addition to the configuration listed above it is also possible to just enable or disable the mail interceptor via an environment variable.

```dotenv
INTERCEPT_EMAILS=true
```

# Local testing

Let's say you want to test some local changes to this package locally in an existing project you can set it up as follows.

Firstly, assuming you have this repository cloned on the same level as the project where you want to test this package
with, add the following to the `repositories` section in the `composer.json`:
```json
"repositories": [
    {
        "type": "path",
        "url": "../laravel-mail-interceptor"
    }
]
```

Secondly, change the dependency in the `composer.json` to point to your local branch:
```json
"require": {
    "paqtcom/mail-interceptor": "dev-master"
}
```

Lastly, update the dependency to make sure all necessary dependencies will be installed:
```bash
composer update paqtcom/mail-interceptor
```

# Contributing
Any PAQT.com team(member) can submit a PR to this package. Only Lead Developers and two designated responsible
team members can approve and merge these PR's. For a PR to be merged atleast one of the two designated team members
should have approved. The designated team members should have a sense of the direction this package is going towards
and can detect breaking changes more easily because they know of the previous changes made to the code.

### Designated team members
-   Ian Scheele <ian.scheele@paqt.com>
-   Dennis Coorn <dennis.coorn@paqt.com>
