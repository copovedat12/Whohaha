var gulp = require('gulp'),
	sass = require('gulp-sass'),
  notify = require('gulp-notify'),
  babel = require('gulp-babel'),
  concat = require('gulp-concat'),
  uglify = require('gulp-uglify'),
  sourcemaps = require('gulp-sourcemaps');

gulp.task('styles', function(){
  gulp.src('./resources/scss/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle : 'compressed'}).on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./css'))
    .pipe(notify('Styles compressed'));
});

gulp.task('scripts', function(){
  gulp.src([
    './resources/js/vendor/*.js',
    './resources/js/script.js',
    './resources/js/whh-woocommerce.js',
    './resources/js/nav-tags.js',
    './resources/js/friend-finder.js'
    ])
    .pipe(sourcemaps.init())
    .pipe(babel({
      presets : ['es2015'],
      only : 'script.js'
    }))
    .pipe(concat('scripts.js'))
    .pipe(uglify())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./js'))
    .pipe(notify('Scripts created'));
});

gulp.task('watch', function(){
  gulp.watch('./resources/scss/**/*.scss', ['styles']);
  gulp.watch([
    './resources/js/vendor/*.js',
    './resources/js/script.js',
    './resources/js/nav-tags.js',
    './resources/js/friend-finder.js'
    ], ['scripts']);
});

gulp.task('default', ['scripts', 'styles', 'watch']);