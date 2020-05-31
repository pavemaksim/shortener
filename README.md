# Shortener

Extremely simple service to shorten some URLs.

# Usage 

Navigate to `/shortcode/create` and enjoy!

# Requirements

- Docker 19.03
- docker-compose 1.25

# Installation

- Clone source code
- Run `docker-compose up`
- Navigate to `http://symfony.localhost/`

# Considerations

This service is created only for demonstration purposes:

- Make sure to use persistent storage (e.g. docker volumes) for db image
- Make sure to use ENV variables for your environment settings for different images (db, php-fpm)
- Make sure to use user-friendly UI :)
