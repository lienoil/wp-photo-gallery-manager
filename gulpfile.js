var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    cssnano = require('gulp-cssnano'),
    jshint = require('gulp-jshint'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cache = require('gulp-cache'),
    livereload = require('gulp-livereload'),
    del = require('del');

var directories = {
    assets: {
        css: 'assets/css',
        js: 'assets/js',
        fonts: 'assets/fonts',
        img: 'assets/img',
    },
    build: {
        css: 'build/css',
        js: 'build/js',
        fonts: 'build/fonts',
        img: 'build/img',
    },
    dist: {
        css: 'dist/css',
        js: 'dist/js',
        fonts: 'dist/fonts',
        img: 'dist/img',
    },
    public: {
        css: 'public/css',
        js: 'public/js',
        fonts: 'public/fonts',
        img: 'public/img',
    },
    root: {
        css: 'css',
        js: 'js',
        fonts: 'fonts',
        img: 'img',
    },
}

/*
| # SASS
|
| The sass files to be converted as css
| and saved to different folders.
|
| @run  gulp sass
|
*/
gulp.task('sass', function () {
    return sass('resources/sass/app.scss', { style: 'expanded' })
        .pipe(autoprefixer('last 2 version'))
        .pipe(gulp.dest(directories.assets.css))
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(gulp.dest(directories.assets.css))
        .pipe(notify({ message: 'Completed compiling SASS Files' }));
});

/*
| # Scripts
|
| The js files to be concatinated
| and saved to different folders.
|
| @run  gulp scripts
|
*/
gulp.task('scripts', function () {
    return gulp.src('resources/scripts/**/*.js')
        .pipe(concat('app.js'))
        .pipe(gulp.dest(directory.js.build))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest(directory.js.build))
        .pipe(gulp.dest(directory.js.dist))
        .pipe(notify({ message: 'Completed compiling JS Files' }));
});

/*
| # Images
|
| The img files to be optimized
| and saved to different folders.
|
| @run  gulp images
|
| @destination
|       - ./img/
*/
gulp.task('images', function () {
    return gulp.src(['resources/images/**/*'])
        .pipe(cache(imagemin({ optimizationLevel: 5, progressive: true, interlaced: true })))
        .pipe(gulp.dest(directories.assets.img))
        .pipe(notify({ message: 'Images optimization complete' }));
});

/*
| # Clean
|
| @run  gulp clean
*/
gulp.task('clean', function () {
    return del(['css', 'js', 'img']);
});

/*
| # Default Task
|
| @run  gulp default
*/
gulp.task('default', ['clean'], function () {
    gulp.start('sass', 'scripts', 'images');
});

/*
| # Watcher
|
| @run  gulp watch
*/
gulp.task('watch', function () {
    // Create LiveReload server
    // livereload.listen();
    // Watch any files in , reload on change
    // gulp.watch(['**']).on('change', livereload.changed);

    // Watch .scss files
    gulp.watch('resources/sass/**/*.scss', ['sass']);
    // Watch .js files
    gulp.watch('resources/scripts/**/*.js', ['scripts']);
    // Watch image files
    gulp.watch('resources/images/**/*', ['images']);
});