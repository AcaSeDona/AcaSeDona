var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    watch = require('gulp-watch'),
    notify = require('gulp-notify'),
    gutil = require('gulp-util');

var config = {
    pathSass: 'sass',
    pathJS: 'js',
    pathBower: 'bower_components',
    pathNode: 'node_modules'
};

var jsvendor_files = [
    config.pathBower + '/html5shiv/dist/html5shiv.min.js',
    config.pathBower + '/jquery/jquery.min.js',
    config.pathBower + '/bootstrap-sass/assets/javascript/bootstrap.min.js',
    //config.pathBower + '/jquery-cycle2/build/jquery.cycle2.min.js',
    config.pathBower + '/gmaps/gmaps.min.js',
    //config.pathBower + '/sharrre/jquery.sharrre.min.js'
    config.pathBower + '/bootstrap-timepicker/js/bootstrap-timepicker.js'
];

gulp.task('vendor-scripts', function () {
    return gulp.src(jsvendor_files)
        .pipe(uglify({mangle: false}).on('error', gutil.log))
        .pipe(concat('vendors.js'))
        .pipe(gulp.dest('../assets/js'))
        .pipe(notify({
            title: 'Donaciones Inundaciones',
            message: 'Vendor scripts published.'
        }));
});

var js_files = [
    config.pathJS + '/code.js'
];

gulp.task('js', function () {
    return gulp.src(js_files)
        .pipe(uglify({mangle: false}).on('error', gutil.log))
        .pipe(concat('app.js'))
        .pipe(gulp.dest('../assets/js'))
        .pipe(notify({
            title: 'Donaciones Inundaciones',
            message: 'Minified scripts published.'
        }));
});

gulp.task('sass', function () {
    return sass(config.pathSass + '/app.scss', {style: 'expanded'})
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(concat('app.css'))
        .pipe(minifycss({keepSpecialComments: 0}))
        .pipe(gulp.dest('../assets/css'))
        .pipe(notify({
            title: 'Donaciones Inundaciones',
            message: 'Sass styles published.'
        }));
});

gulp.task('deploy-fontawesome-icons', function () {
    return gulp.src(config.pathBower + '/fontawesome/fonts/**.*')
        .pipe(gulp.dest('../assets/fonts'))
        .pipe(notify({
            title: 'Donaciones Inundaciones',
            message: 'Font Awesome fonts published.'
        }));
});

gulp.task('watch', function () {
    gulp.watch(['js/**/*.js'], ['js']);
    gulp.watch(['sass/**/*.scss'], ['sass']);
});

gulp.task('default', ['watch']);
