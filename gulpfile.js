var gulp = require('gulp');
var elixir = require('laravel-elixir');

/**
 * 拷贝任何需要的文件
 *
 * Do a 'gulp copyfiles' after bower updates
 */
gulp.task("copyfiles", function() {
    // jquery
    gulp.src("vendor/bower_dl/jquery/dist/jquery.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // bootstrap
    gulp.src("vendor/bower_dl/bootstrap/less/**")
        .pipe(gulp.dest("resources/assets/less/bootstrap"));

    gulp.src("vendor/bower_dl/bootstrap/dist/js/bootstrap.js")
        .pipe(gulp.dest("resources/assets/js/"));

    gulp.src("vendor/bower_dl/bootstrap/dist/fonts/**")
        .pipe(gulp.dest("public/assets/fonts"));

    // font-awesome
    gulp.src("vendor/bower_dl/font-awesome/less/**")
        .pipe(gulp.dest("resources/assets/less/font-awesome"));

    // sweetalert
    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.css")
        .pipe(gulp.dest('public/assets/css'));

    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.min.js")
        .pipe(gulp.dest('public/assets/js/'));

    // vue
    gulp.src("vendor/bower_dl/vue/dist/vue.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // vue-resource
    gulp.src("vendor/bower_dl/vue-resource/dist/vue-resource.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // vue-async-data
    gulp.src("vendor/bower_dl/vue-async-data/vue-async-data.js")
        .pipe(gulp.dest("resources/assets/js/"));

    // adminLTE
    gulp.src("vendor/bower_dl/AdminLTE/dist/js/app.js")
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src("vendor/bower_dl/AdminLTE/dist/css/AdminLTE.css")
        .pipe(gulp.dest('public/assets/css/'));

    gulp.src("vendor/bower_dl/AdminLTE/plugins/**")
        .pipe(gulp.dest('public/assets/js/plugins'));

    // ionicons
    gulp.src("vendor/bower_dl/Ionicons/less/**")
        .pipe(gulp.dest('resources/assets/less/ionicons'));

    gulp.src("vendor/bower_dl/Ionicons/fonts/**")
        .pipe(gulp.dest('public/assets/fonts'));

});

/**
 * Default gulp is to run this elixir stuff
 */
elixir(function(mix) {

    // 合并 scripts
    mix.scripts(['js/jquery.js', 'js/bootstrap.js', 'js/vue.js', 'js/vue-resource.js', 'js/vue-async-data.js'],
        'public/assets/js/admin.js',
        'resources/assets'
    );

    // 编译 Less
    mix.less('admin.less', 'public/assets/css/admin.css');
});
