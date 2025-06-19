// gulpfile.js

const { src, dest, watch, parallel } = require('gulp');
const sass         = require('gulp-sass')(require('sass'));
const postcss      = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano      = require('cssnano');
const rename       = require('gulp-rename');
const uglify       = require('gulp-uglify');

// Base path to your theme
const themeBase = 'wp-content/themes/tdm-business/assets/';

const paths = {
  scss: {
    globalEntry: `${themeBase}scss/global/global.scss`,
    layout: [
      `${themeBase}scss/layout/**/*.scss`,
      `!${themeBase}scss/layout/**/style.scss`
    ],
    destGlobal: `${themeBase}css/`,
    destLayout: `${themeBase}css/layout/`
  },
  js: {
    src:  [`${themeBase}js/**/*.js`, `!${themeBase}js/**/*.min.js`],
    dest: `${themeBase}js/min/`
  }
};

// 1) Global styles → single global.min.css
function stylesGlobal() {
  return src(paths.scss.globalEntry)
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(rename('global.min.css'))
    .pipe(dest(paths.scss.destGlobal));
}

// 2) Layout styles → each file flattened into layout folder
function stylesLayout() {
  return src(paths.scss.layout)
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(paths.scss.destLayout));
}

// 3) JS minification
function scripts() {
  return src(paths.js.src)
    .pipe(uglify())
    .pipe(rename({ suffix: '.min' }))
    .pipe(dest(paths.js.dest));
}

// 4) Watcher: now watching entire directories, not just the single files
function watchFiles() {
  // If *any* file under `assets/scss/global/` changes → rebuild global.scss
  watch(`${themeBase}scss/global/**/*.scss`, stylesGlobal);

  // If *any* file under `assets/scss/layout/` changes → rebuild layout SCSS
  watch(`${themeBase}scss/layout/**/*.scss`, stylesLayout);

  // If any un-minified JS under assets/js/ changes → rebuild
  watch(paths.js.src, scripts);
}

// Default task: build everything once, then start watching
exports.default = parallel(
  stylesGlobal,
  stylesLayout,
  scripts,
  watchFiles
);

exports.stylesGlobal = stylesGlobal;
exports.stylesLayout = stylesLayout;
exports.scripts      = scripts;
exports.watch        = watchFiles;
