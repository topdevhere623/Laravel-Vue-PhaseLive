## Main Installation
After cloning the repository the following actions must be complete:

1. Run `composer install`
1. Copy `.env.example` to `.env`
1. Run `php artisan key:generate`
1. Check newly created `.env` and set required environment variables (see 3rd party services below)
1. Run `php artisan migrate --seed`