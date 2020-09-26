const gulp = require('gulp');
const sass = require('gulp-sass');
const cssmin = require('gulp-cssmin');
const rename = require('gulp-rename');
const rimraf = require('rimraf');
const pug = require('gulp-pug');
const concat = require('gulp-concat');
const sourcemaps = require('gulp-sourcemaps');
const browserSync = require('browser-sync').create();

//Очистка
function delete_build(cb){
        rimraf('./build', cb);
}

//Отслеживание
function watch_build(){
    browserSync.init({
        server: {
            baseDir: "./build"
        }
    });
    gulp.watch("./src/sass/**/*.sass", merge_css);
    gulp.watch("./src/pug/**/*.pug", pug_build);
}

//FA иконки
function font_awesome_icons(){
  return gulp.src('node_modules/font-awesome/fonts/*.*')
        .pipe(gulp.dest('./build/fonts'));
}

//FA стили
function font_awesome_style(){
  return gulp.src('node_modules/font-awesome/css/font-awesome.min.css')
        .pipe(gulp.dest('./build/css'));
}

//Добавление reset.css
function reset_css(){
  return gulp.src('node_modules/reset-css/reset.css')
        .pipe(gulp.dest('./src/sass/common'));
}

//Слияние CSS
function merge_css(){
        sass_build()
  return gulp.src(['./src/sass/common/reset.css','./src/tmp/styles_tmp.min.css'])
        .pipe(concat('styles.min.css'))
        .pipe(gulp.dest('./build/css'))
        .pipe(browserSync.stream());
}

//Компиляция CSS
function sass_build(){
  return gulp.src('./src/sass/*.sass')
        .pipe(sass())
        .pipe(cssmin())
        .pipe(rename({suffix: '_tmp.min'}))
        .pipe(sourcemaps.init())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('./src/tmp'));
}

//Компиляция HTML
function pug_build(){
  return gulp.src('./src/pug/pages/*.pug')
  			.pipe(pug({}))
	  		.pipe(gulp.dest('./build'))
	  		.pipe(browserSync.stream());
}

//Список команд
exports.merge = merge_css
exports.delete = delete_build;
exports.watch = watch_build;
exports.sass = sass_build;
exports.pug = pug_build;
exports.build = gulp.parallel(sass_build, pug_build, reset_css, font_awesome_icons, font_awesome_style);