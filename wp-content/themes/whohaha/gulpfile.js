var gulp = require('gulp'),
	sass = require('gulp-ruby-sass'),
	rename = require('gulp-rename'),
	rename = require('gulp-minify-css');

gulp.task('twbs-styles', function(){
  sass('./bootstrap/assets/stylesheets/bootstrap.scss', {style: 'expanded'})
	.pipe(rename('bootstrap.css'))
    .pipe(gulp.dest('css'));
});

gulp.task('styles', function(){
  sass('./resources/scss/style.scss', {style: 'expanded'})
  	.pipe(rename('dev_styles.css'))
    .pipe(gulp.dest('css'));
});

gulp.task('watch', function(){
  gulp.watch('./bootstrap/assets/stylesheets/**/*.scss', ['twbs-styles']);
  gulp.watch('./resources/scss/**/*.scss', ['styles']);
});

gulp.task('default', ['twbs-styles', 'styles', 'watch']);