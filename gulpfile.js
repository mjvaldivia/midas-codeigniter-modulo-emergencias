var gulp = require("gulp");
var uglify = require("gulp-uglify");
var rename = require("gulp-rename");
var css = require("gulp-minify-css");

var getBaseDir = function(file) {
    return file.base;
};

gulp.task("js", function() {
    gulp.src(["assets/**/*.js", "!assets/**/*.min.js", "!assets/lib/**/*"])
        .pipe(uglify())
        .pipe(rename({
            extname: ".min.js"
        }))
        .pipe(gulp.dest(getBaseDir));
});

gulp.task("css", function() {
    gulp.src(["assets/**/*.css", "!assets/**/*.min.css"])
        .pipe(css())
        .pipe(rename({
            extname: ".min.css"
        }))
        .pipe(gulp.dest(getBaseDir));
});

gulp.task("watch", function () {
    gulp.watch(["assets/**/*.js", "!assets/**/*.min.js", "!assets/lib/**/*"], ["js"]);
    gulp.watch(["assets/**/*.css", "!assets/**/*.min.css"], ["css"]);
});

gulp.task("default", ["js", "css", "watch"]);