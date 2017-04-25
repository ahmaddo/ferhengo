var gulp = require('gulp');

const DESTINATION = 'dest/';

gulp.task('copy', function(){
    return gulp
        .src('app/*')
        .pipe(gulp.dest(DESTINATION + 'tests'));
})
    .task('run', function(){
        return gulp
            .src('app/class/*')
            .pipe(gulp.dest(DESTINATION + 'tests/class'));
    })

    .task('vendor', function(){
        return gulp
            .src(['vendor/*', 'vendor/*'])
            .pipe(gulp.dest(DESTINATION + 'vendor'));
    })

    .task('tests', function(){
        return gulp
            .src('app/tests/*/**')
            .pipe(gulp.dest(DESTINATION));
    })

    .task('default', [ 'run', 'copy', 'vendor', 'tests']);

