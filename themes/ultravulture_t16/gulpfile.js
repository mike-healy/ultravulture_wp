'use strict';
 
var gulp = require('gulp');
var sass = require('gulp-sass');

var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');

gulp.task('sass', function () {
  //return gulp.src('./sass/**/*.scss')
  return gulp.src('./*.scss')
    .pipe(sass({outputStyle: 'nested'}).on('error', sass.logError))
    .pipe(gulp.dest('.'));
});
 
gulp.task('sass:watch', function () {
  //gulp.watch('./sass/**/*.scss', ['sass']);
  gulp.watch('./*.scss', ['sass']);
});


gulp.task('minify', function () {
  //gulp.src('src/**/*.css')
  gulp.src('style.css')
      .pipe(cssmin())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest('.'));

  return Promise.resolve('donezo');
});
