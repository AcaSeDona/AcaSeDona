# #AcaSeDona

![AcaSeDona](http://i.imgur.com/IenCMxj.png)

> AcaSeDona is a collaborative map that has locations where donations are received, all in one place. Let's help to help!  
> [http://www.acasedona.com.ar](http://www.acasedona.com.ar)

## Tech requirements

* PHP 5.4+
* MySQL 5+ (or SQLite)
* Composer
* NodeJS
* Bower
* Sass

## Passwords and keys (.env)

This project uses a `.env` file to manage passwords and keys configuration.


You have to duplicate the `.env.example` file, and rename it `.env`. After this, complete with the correct information (database, backend, recaptcha, google analytics, google maps api and facebook app id).

## PHP Packages with Composer

This project uses **Composer** to manage php vendors. To install we have to do:

```
$ composer install
```

### Composer packages used in this project

* [FlightPHP](http://flightphp.com/)
* [Wing Commander](https://github.com/xmeltrut/WingCommander)
* [Laravel Eloquent](http://laravel.com/docs/4.2/eloquent)
* [reCAPTCHA](https://www.google.com/recaptcha/)
* [Google Maps Geocoder](https://github.com/jstayton/GoogleMapsGeocoder)
* [Slugify](https://github.com/cocur/slugify)
* [BanBuilder](http://banbuilder.com/)
* [Simple Flash](https://github.com/tamtamchik/simple-flash)
* [phpdotenv](https://github.com/vlucas/phpdotenv)

## Database (schema with Eloquent)

If you want to use the table that this project uses, you can do so at the `AcaSeDona/Support/database.php` file.

You have to change the variable `$create_tables` to `true`. The next time you visit the website (with the correct database connection information), the table will be created.

But after you created the table you have to change back the variable `$create_tables` to false, because the system will try to create the already created table again.

## Assets Management (Gulp + NodeJS)

This project uses **Gulp** to compile its assets (Sass + JS).

We can find it in the `client` folder. To install the **NodeJS** packages, we have to go into `client` folder and run:

```
$ bower install
$ sudo npm install
```

Then we have to globally install **Gulp** (if we haven't done it yet):

```
$ sudo npm install --global gulp
```

To auto generate the production files while we are working (they are at the `assets` folder),
we have to be in the `client` folder, and then run:

```
$ gulp
```

This will keep running, *watching* the files change, and then auto generating the final files.

If you want to run manually the compilation scripts, you have these two commands:

```
$ gulp sass
$ gulp js
```

There is something else you have to know: If you are going to add or remove a JS file,
you have to add/remove them from the `gulpfile.js` or else the Gulp script won't work.
There are an array that have this list: `js_files`. Please verify this, if you are
going to change the file structure at the `client/js` folder.

### Bower packages used in this project

* [Bootstrap Sass](http://getbootstrap.com/css/#sass)
* [Bourbon](http://bourbon.io/)
* [Neat](http://neat.bourbon.io/)
* [Font Awesome](http://fontawesome.io/)
* [jQuery](https://jquery.com/)
* [Cycle 2](http://jquery.malsup.com/cycle2/)
* [html5shiv](https://github.com/afarkas/html5shiv)
* [gmaps.js](https://hpneo.github.io/gmaps/)
* [Bootstrap Timepicker](http://jdewit.github.io/bootstrap-timepicker/)
* [Typeahead for Bootstrap 3](https://github.com/bassjobsen/Bootstrap-3-Typeahead)
* [Sharrre](http://sharrre.com/)

### NodeJS packages used in this project

* [Gulp](http://gulpjs.com/)
* [gulp-autoprefixer](https://www.npmjs.com/package/gulp-autoprefixer)
* [gulp-cache](https://www.npmjs.com/package/gulp-cache)
* [gulp-concat](https://www.npmjs.com/package/gulp-concat)
* [gulp-jshint](https://www.npmjs.com/package/gulp-jshint)
* [gulp-minify-css](https://www.npmjs.com/package/gulp-minify-css)
* [gulp-notify](https://www.npmjs.com/package/gulp-notify)
* [gulp-rename](https://www.npmjs.com/package/gulp-rename)
* [gulp-ruby-sass](https://www.npmjs.com/package/gulp-ruby-sass)
* [gulp-uglify](https://www.npmjs.com/package/gulp-uglify)
* [gulp-util](https://www.npmjs.com/package/gulp-util)
* [gulp-watch](https://www.npmjs.com/package/gulp-watch)

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Make your changes
4. Commit your changes (`git commit -am 'Added some feature'`)
5. Push to the branch (`git push origin my-new-feature`)
6. Create new Pull Request
