var gulp = require("gulp");
var uglify = require("gulp-uglify");
var rename = require("gulp-rename");
var css = require("gulp-minify-css");

gulp.task("js", function() {
    gulp.src(["assets/**/*.js", "!assets/**/*.min.js", "!*lib*"])
        .pipe(uglify())
        .pipe(rename({
            extname: ".min.js"
        }))
        .pipe(gulp.dest(function(file) {
            return file.base;
        }));
});

gulp.task("css", function() {
    gulp.src(["assets/**/*.css", "!assets/**/*.min.css"])
        .pipe(css())
        .pipe(rename({
            extname: ".min.css"
        }))
        .pipe(gulp.dest(function(file) {
            return file.base;
        }));
});

gulp.task("watch", function () {
    gulp.watch(["assets/**/*.js", "!assets/**/*.min.js"], ["js"]);
    gulp.watch(["assets/**/*.css", "!assets/**/*.min.css"], ["css"]);
});

gulp.task("default", ["js", "css", "watch"]);