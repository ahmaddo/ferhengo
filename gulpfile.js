var gulp = require('gulp');

const DESTINATION = 'dest/';

gulp.task('copy', function(){
    return gulp
        .src('app/*/**')
        .pipe(gulp.dest(DESTINATION));
})
    .task('default', ['copy']);

