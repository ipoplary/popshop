var gulp = require('gulp');
var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;
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
        .pipe(gulp.dest("public/build/assets/fonts"));

    // font-awesome
    gulp.src("vendor/bower_dl/font-awesome/less/**")
        .pipe(gulp.dest("resources/assets/less/font-awesome"));

    gulp.src("vendor/bower_dl/font-awesome/fonts/**")
        .pipe(gulp.dest("public/build/assets/fonts"));

    // sweetalert
    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.css")
        .pipe(gulp.dest('resources/assets/css'));

    gulp.src("vendor/bower_dl/sweetalert/dist/sweetalert.min.js")
        .pipe(gulp.dest('resources/assets/js/'));

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
        .pipe(gulp.dest('resources/assets/css/'));

    gulp.src("vendor/bower_dl/AdminLTE/dist/css/skins/_all-skins.min.css")
        .pipe(gulp.dest('resources/assets/css/'));

    // gulp.src("vendor/bower_dl/AdminLTE/plugins/**")
    //     .pipe(gulp.dest('public/assets/js/plugins'));

    // ionicons
    gulp.src("vendor/bower_dl/Ionicons/less/**")
        .pipe(gulp.dest('resources/assets/less/ionicons'));

    gulp.src("vendor/bower_dl/Ionicons/fonts/**")
        .pipe(gulp.dest('public/build/assets/fonts'));

    // vue-sortable
    gulp.src("node_modules/sortablejs/Sortable.min.js")
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src("node_modules/vue-sortable/vue-sortable.js")
        .pipe(gulp.dest('resources/assets/js/'));

    // summernote
    gulp.src("vendor/bower_dl/summernote/dist/summernote.css")
        .pipe(gulp.dest('resources/assets/css/'));

    gulp.src("vendor/bower_dl/summernote/dist/summernote.js")
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src("vendor/bower_dl/summernote/dist/font/**")
        .pipe(gulp.dest('public/build/assets/css/font/'));

    // jquery-form
    gulp.src("vendor/bower_dl/jquery-form/jquery.form.js")
        .pipe(gulp.dest('resources/assets/js/'));

    // jquery-file-upload
    gulp.src("node_modules/jquery-file-upload/js/jquery.uploadfile.min.js")
        .pipe(gulp.dest('resources/assets/js/'));

    gulp.src("node_modules/jquery-file-upload/css/uploadfile.css")
        .pipe(gulp.dest('resources/assets/css/'));

});

/**
 * Default gulp is to run this elixir stuff
 */
elixir(function(mix) {

    // 合并 scripts
    mix.scripts(
        [
            'js/jquery.js',
            'js/bootstrap.js',
            'js/vue.js',
            'js/vue-resource.js',
            'js/vue-async-data.js',
            'js/Sortable.min.js',
            'js/vue-sortable.js',
            'js/app.js',
            'js/sweetalert.min.js',
            'js/summernote.js',
            'js/jquery.form.js',
            'js/jquery.uploadfile.min.js',
        ],
        'public/assets/js/admin.js',
        'resources/assets'
    );

    // 编译 Less
    mix.less('admin.less', 'resources/assets/css/admin.css');

    // 合并 css
    mix.styles(
        [
            'css/admin.css',
            'css/sweetalert.css',
            'css/AdminLTE.css',
            'css/_all-skins.min.css',
            'css/summernote.css',
            'css/uploadfile.css',
        ],
        'public/assets/css/admin.css',
        'resources/assets'
    );

    elixir(function(mix) {
        mix.version(['assets/css/admin.css', 'assets/js/admin.js']);
    });
});
