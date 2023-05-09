[//]: # (# Feed It Back Technical Test)

[//]: # ()
[//]: # (## Setup)

[//]: # ()
[//]: # (Ensure you have Docker installed. If you are using windows be se aware you will need to enable [WSL2]&#40;https://laravel.com/docs/9.x/installation#getting-started-on-windows&#41;)

[//]: # ()
[//]: # (Start by referring to the [Docs]&#40;https://laravel.com/docs/9.x/sail#installing-composer-dependencies-for-existing-projects&#41; for steps on how to install dependencies for existing applications.)

[//]: # ()
[//]: # (Add an [alias]&#40;https://laravel.com/docs/9.x/sail#configuring-a-bash-alias&#41; for sail .)

[//]: # ()
[//]: # (Then run the migration and seeder to populate your database with genres:)

[//]: # ()
[//]: # (- `sail up -d`)

[//]: # (- `sail artisan migrate`)

[//]: # (- `sail artisan db:seed`)

[//]: # ()
[//]: # (## The task)

[//]: # ()
[//]: # (You have been tasked with creating an API for a Movie Database website. A user will be able to submit a form to add a movie as well as viewing a list of all movies with a few filters available.)

[//]: # (We have provided a starting point, including some models, factories, migrations and general guidance has been added as comments in the controller.)

[//]: # ()
[//]: # (A movie will contain the following data:)

[//]: # ()
[//]: # (- Name )

[//]: # (- User ID)

[//]: # (- Synopsis)

[//]: # (- Image URL)

[//]: # (- Release Date &#40;Y-m-d&#41;)

[//]: # (- Rating &#40;U, PG, 12a, 12, 15, 18&#41;)

[//]: # (- Award winning &#40;bool&#41;)

[//]: # ()
[//]: # (Additionally a movie can also be associated with genres and actors. There is a need in the future for genres to be able to be associated with other entities e.g Tv Shows/Music/Books/Games. You should architect a solution for this realtionship with this in mind. )

[//]: # ()
[//]: # (The following genres have been provided via a seeder:)

[//]: # ()
[//]: # (- Comedy)

[//]: # (- Action)

[//]: # (- Horror)

[//]: # (- Sci-fi)

[//]: # (- Romance)

[//]: # (- Drama)

[//]: # ()
[//]: # (Users may associate as many genres/actors with a movie as they like.)

[//]: # ()
[//]: # (Users will be able to filter movies by their release date as well as genres and actors. When filtering by genres and actors at the same time OR functionality should be applied. All of the filters are optional.)

[//]: # ()
[//]: # (## Recommended steps)

[//]: # ()
[//]: # (- Start by outlining some feature tests to facilitate TDD)

[//]: # (- Decide on the relevant relationships needed - done)

[//]: # (- Write migrations for the tables to facilitate those relationships - done)

[//]: # (- Add the relationships to the movie model. - done)

[//]: # (- Update the factory to use the relationships and seed 5000 movies in to the DB - done)

[//]: # (- Build endpoints - done)

[//]: # (- Write feature tests. - done)

[//]: # ( )
[//]: # (## Things to consider)

[//]: # ()
[//]: # (### Responses)

[//]: # ()
[//]: # (- We use JsonResource classes to return responses from our API, you should build your endpoints to do the same)

[//]: # ()
[//]: # (### Relationships / Database design)

[//]: # ()
[//]: # (- Table structure for relationship. Keep in mind genres will need to support multiple different models in the future.)

[//]: # ()
[//]: # (### Tests)

[//]: # ()
[//]: # (- Robust feature tests, which cover submitting invalid data to test validation and assert correct responses returned from the API)

[//]: # (- We use [Pest PHP]&#40;https://pestphp.com/docs/installation&#41; for our tests, we suggest you do the same. We have required pest in the project and setup a starting point for you.)

[//]: # (- Use `sail composer pest` to run your tests.)

[//]: # ()
[//]: # (### General)

[//]: # ()
[//]: # (- Performance, avoid performing unnecessary queries.)

[//]: # ()
[//]: # (## Bonus Points)

[//]: # ()
[//]: # (If you want to go above and beyond you can extend the endpoints to allow a user to update/delete movies which they uploaded. Alternatively you can provide notes on how you would implement this.)

[//]: # ()
[//]: # (## Thank you)

[//]: # ()
[//]: # (Thank you for taking the time to review our technical test specification. If you have any questions please contact devsupport@feeditback.com. Good luck with your application!)

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
