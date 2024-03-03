const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));

gulp.task("sass", function () {
  return gulp
    .src("./web/static/styles/*.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(gulp.dest("./web/static/styles/css"));
});
gulp.task("watch", function () {
  console.log("watch");
  gulp.watch("./web/static/styles/*.scss", gulp.series("sass"));
});
// Default Task
gulp.task("default", gulp.parallel("watch", "sass"));
