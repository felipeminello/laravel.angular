var elixir = require('laravel-elixir');
var liveReload = require('gulp-livereload');
var clean = require('gulp-clean');
var gulp = require('gulp');

gulp.task('teste', function() {
    console.log('está funcionando');
});

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss');
});
