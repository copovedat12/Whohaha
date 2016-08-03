var gulp = require('gulp'),
	sass = require('gulp-sass'),
  notify = require('gulp-notify');

gulp.task('twbs-styles', function(){
  gulp.src('./bootstrap/assets/stylesheets/bootstrap.scss')
    .pipe(sass({outputStyle : 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest('css'))
    .pipe(notify('Bootstrap Styles compressed'));
});

gulp.task('styles', function(){
  gulp.src('./resources/scss/style.scss')
    .pipe(sass({outputStyle : 'compressed'}).on('error', sass.logError))
    .pipe(gulp.dest('css'))
    .pipe(notify('Styles compressed'));
});

gulp.task('watch', function(){
  gulp.watch('./bootstrap/assets/stylesheets/**/*.scss', ['twbs-styles']);
  gulp.watch('./resources/scss/**/*.scss', ['styles']);
});

gulp.task('default', ['twbs-styles', 'styles', 'watch']);