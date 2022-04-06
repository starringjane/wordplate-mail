![Starring Jane](logo.png)

# Wordplate Mail

Adds mail settings to your environment configuration

## Installation

```sh
composer require starring-jane/wordplate-mail
```

Create a WordplateMail instance in `functions.php`

```php
use StarringJane\WordplateMail\WordplateMail;

WordplateMail::register();
```

## Usage

Add your smtp settings to your .env file

```php
MAIL_DRIVER=smtp
MAIL_HOST=localhost
MAIL_PORT=465
MAIL_USERNAME=user
MAIL_PASSWORD=pass
MAIL_ENCRYPTION=tls
MAIL_FROM_NAME="Sender Name"
MAIL_FROM_ADDRESS="no-reply@domain.com"
```

You can also send trough the local mail driver

```php
MAIL_DRIVER=mail
MAIL_HOST=localhost
MAIL_PORT=25
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_NAME="Sender Name"
MAIL_FROM_ADDRESS="no-reply@domain.com"
```

## Contributors

* Maxim Vanhove (maxim@starringjane.com) [![Twitter Follow](https://img.shields.io/twitter/follow/MrMaximVanhove.svg?style=social&logo=twitter&label=Follow)](https://twitter.com/MrMaximVanhove)

## Credits

Special thanks to the contributors of [wordplate](https://github.com/wordplate/wordplate) for allowing us to create Wordpress websites in a modern development environment
