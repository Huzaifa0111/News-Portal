import { task, src, dest, watch } from "gulp";
var browserSync = require("browser-sync").create();

// Copy third party libraries from /node_modules into /vendor
task("vendor", function () {
  // Bootstrap
  src([
      "./node_modules/bootstrap/dist/**/*",
      "!./node_modules/bootstrap/dist/css/bootstrap-grid*",
      "!./node_modules/bootstrap/dist/css/bootstrap-reboot*",
    ])
    .pipe(dest("./vendor/bootstrap"));

  // jQuery
  src([
      "./node_modules/jquery/dist/*",
      "!./node_modules/jquery/dist/core.js",
    ])
    .pipe(dest("./vendor/jquery"));
});

// Default task
task("default", ["vendor"]);

// Configure the browserSync task
task("browserSync", function () {
  browserSync.init({
    server: {
      baseDir: "./",
    },
  });
});

// Dev task
task("dev", ["browserSync"], function () {
  watch("./css/*.css", browserSync.reload);
  watch("./*.html", browserSync.reload);
});
