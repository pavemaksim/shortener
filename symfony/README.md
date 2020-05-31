# Shortener

Extremely simple service to shorten some URLs.

# Usage 

Navigate to `/shortcode/create` and woohoo!

# Requirements

- PHP 7.2
- MySQL 5.7
- composer

# Installation

- Clone source code
- Setup your DB credentials: `cp .env.local.example .env.local`
- Run `composer install` in a source dir
- Run migrations `php bin/console doctrine:migrations:migrate`
- Run `symfony server:start` or `php bin/console server:start`

