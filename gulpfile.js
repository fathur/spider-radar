'use strict';

var gulp 	= require('gulp');
var jade 	= require('gulp-jade');
var watch 	= require('gulp-watch');
var sass	= require('gulp-sass');

gulp.task('default', ['jade', 'sass', 'watch']);

gulp.task('jade', function () {
    gulp.src('./app/jade/*.jade')
        .pipe(jade({
            pretty: true
        }))
        .pipe(gulp.dest('./'));
});

gulp.task('sass', function () {
	gulp.src('./app/scss/**/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest('./stylesheet/'));
});

gulp.task('watch', function () {
    gulp.watch('./app/jade/**/*.jade', ['jade']);
    gulp.watch('./app/scss/**/*.scss', ['sass']);
})