# Phase
By [Thunderbolt Digital](https://www.wearethunderbolt.com)

See the guides directory for detailed development guides for this project.

## Project Setup
A list of the things required to get this project up and running as you would expect.

#### Environment

Setup a suitable environment for this application by following the guidelines for [Laravel 5.7](https://laravel.com/docs/5.7/installation)

- PHP Version >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

Serve `/public/index.php` with your web server

#### Config
Make sure `.env` is present and configured.

Copy one of the environments, or use your existing environment.

Run `php artisan key:generate` to create an encryption key

#### Database
Visit the database directory for a full list of migrations and seeders.

For development migrate and seed by running `php artisan migrate --seed`

#### Assets
To link the public assets run `php artisan storage:link`

// TODO explain AWS

#### Composer
Run `composer install` to install packages from the composer.lock file

#### Yarn
Run `yarn install` to install packages from the yarn.lock file

#### Mix
Compiling assets is handled using scripts within package.json

- For production: `yarn run prod`
- For development: `yarn run watch` or `yarn run dev`
- Watch: `yarn run watch`


#### Broadcasting
Instant messaging uses socket.io. All dependencies for this are installed at the start of the project.

To initialise server with all the config specified in the `laravel-echo-server.json`.

Broadcasting events requires echo server to run this execute`laravel-echo-server start`

// TODO Messaging is currently broken

#### BrainTree
// TODO EXPLAIN

#### Stripe
// TODO EXPLAIN

#### AWS Encoding
// TODO EXPLAIN

#### AWS Storage
// TODO EXPLAIN

#### Server Info
Memory limit needs to be set top 512M

# Mailcoach
https://spatie.be/docs/laravel-mailcoach/v4/installation/in-an-existing-laravel-app
use mail from address as username
password stored in lastpass