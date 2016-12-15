var gulp = require('gulp'),
	sass = require('gulp-sass'),
  notify = require('gulp-notify'),
  sourcemaps = require('gulp-sourcemaps');

gulp.task('styles', function(){
  gulp.src('./resources/scss/style.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({outputStyle : 'compressed'}).on('error', sass.logError))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('./css'))
    .pipe(notify('Styles compressed'));
});

gulp.task('watch', function(){
  gulp.watch('./resources/scss/**/*.scss', ['styles']);
});

gulp.task('default', ['styles', 'watch']);