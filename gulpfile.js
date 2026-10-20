// Gulp Build Script

import gulp from 'gulp'
import clean from 'gulp-clean'
import rev from 'gulp-rev'
import concat from 'gulp-concat'
import cleanCSS from 'gulp-clean-css'
import rename from 'gulp-rename'
import uglify from 'gulp-uglify'
import inject from 'gulp-inject'
import logStream from 'gulp-debug'
import series from 'stream-series'
import header from 'gulp-header'
import tar from 'gulp-tar'
import gzip from 'gulp-gzip'
import zip from 'gulp-zip'
import run from 'gulp-run'

import { Stream } from 'readable-stream'
const {finished, pipeline} = Stream.promises


let prod0js;
let prod1js;

// Clear and remove the resources folder
gulp.task('clean', function () {
    return pipeline(
        gulp.src('./public/resources', {read: false, allowEmpty: true}),
        clean()
    );
});

gulp.task('compress', function() {
    const sources = ['app*/**/*', 'public*/**/*', 'vendor*/**/*', '*.md', 'docs/**/*', 'LICENSE', 'docker*', 'Dockerfile', '**/.htaccess', 'writable*/**/*', '.env'] ;
    gulp.src(sources, {encoding: false}).pipe(tar('opensourcepos.tar')).pipe(gulp.dest('dist'));
    return gulp.src(sources, {encoding: false}).pipe(zip('opensourcepos.zip')).pipe(gulp.dest('dist'));
});


gulp.task('update-licenses', function() {
    function run_completion(execStream) {
        return finished(execStream.resume());
    }

    return Promise.all([
        run_completion(run('composer licenses --format=json --no-dev > public/license/composer.LICENSES').exec()),
        run_completion(run('npx license-report --only=prod --output=json --fields=name --fields=author --fields=homepage --fields=installedVersion --fields=licenseType > public/license/npm-prod.LICENSES').exec()),
        run_completion(run('npx license-report --only=dev --output=json --fields=name --fields=author --fields=homepage --fields=installedVersion --fields=licenseType > public/license/npm-dev.LICENSES').exec()),
        pipeline(gulp.src('LICENSE'),gulp.dest('public/license'))
    ]);
});


gulp.task('copy-bootswatch', function() {
    return Promise.all([
        pipeline(gulp.src('./node_modules/bootswatch/dist/*/*.min.css', {base: './node_modules/bootswatch/dist'}), gulp.dest('public/resources/bootswatch')),
        pipeline(gulp.src('./node_modules/bootstrap/dist/css/*.min.css'), gulp.dest('public/resources/bootswatch/bootstrap'))
    ]);
});

// /public/resources/ospos - contains the minimized files to be packed into opensourcepos.min.[css/js]
// /public/resources/[css/js] - contains the unpacked versions to be used in development mode
// /public/resources - contains the packed opensourcepos.min.[css/js] and the jquery.min.js

// Copy JavaScript into a folder which will be used as the source to create opensourcepos.min.js (except for jquery.mn.js)

// Inject will be in the sequence of the files in the stream.  So make sure dependencies are in their proper order


gulp.task('debug-js', function() {
    const debugjs = gulp.src(['./node_modules/jquery/dist/jquery.js',
        './node_modules/jquery-form/src/jquery.form.js',
        './node_modules/jquery-validation/dist/jquery.validate.js',
        './node_modules/jquery-ui-dist/jquery-ui.js',
        './node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        './node_modules/bootstrap-table/dist/bootstrap-table.js',
        './node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
        './node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
        './node_modules/moment/min/moment.min.js',
        './node_modules/daterangepicker/daterangepicker.js',
        './node_modules/es6-promise/dist/es6-promise.js',
        './node_modules/file-saver/dist/FileSaver.js',
        './node_modules/html2canvas/dist/html2canvas.js',
        './node_modules/jspdf/dist/jspdf.umd.js',
        './node_modules/dompurify/dist/purify.js',
        './node_modules/jspdf-autotable/dist/jspdf.plugin.autotable.js',
        './node_modules/xlsx/dist/xlsx.full.min.js',
        './node_modules/tableexport.jquery.plugin/tableExport.min.js',
        './node_modules/chartist/dist/chartist.js',
        './node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.js',
        './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.js',
        './node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.js',
        './node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.js',
        './public/js/imgpreview.full.jquery.js',
        './node_modules/flatpickr/dist/flatpickr.min.js',
        './node_modules/tom-select/dist/js/tom-select.complete.min.js',
        './public/js/ui.js',
        './public/js/manage_tables.js',
        './public/js/nominatim.autocomplete.js']).pipe(rev()).pipe(gulp.dest('public/resources/js'));
    return gulp.src('./app/Views/partial/header.php').pipe(inject(debugjs,{addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:debug:js -->'})).pipe(gulp.dest('./app/Views/partial'));
});

gulp.task('prod-js', function() {

    const prod0js = gulp.src('./node_modules/jquery/dist/jquery.min.js').pipe(rev()).pipe(gulp.dest('public/resources'));

    const opensourcepos1js = gulp.src(['./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js',
        './node_modules/bootstrap-table/dist/bootstrap-table.min.js',
        './node_modules/moment/min/moment.min.js',
        './node_modules/jquery-ui-dist/jquery-ui.min.js',
        './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js',
        './node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js',
        './node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.min.js',
        './node_modules/jquery-form/dist/jquery.form.min.js',
        './node_modules/jquery-validation/dist/jquery.validate.min.js',
        './node_modules/es6-promise/dist/es6-promise.min.js',
        './node_modules/file-saver/dist/FileSaver.min.js',
        './node_modules/file-saver/dist/FileSaver.js',
        './node_modules/html2canvas/dist/html2canvas.min.js',
        './node_modules/chartist/dist/chartist.min.js',
        './node_modules/jspdf/dist/jspdf.umd.min.js',
        './node_modules/dompurify/dist/purify.min.js',
        './node_modules/chartist/dist/chartist.min.js',
        './node_modules/chartist-plugin-pointlabels/dist/chartist-plugin-pointlabels.min.js',
        './node_modules/chartist-plugin-axistitle/dist/chartist-plugin-axistitle.min.js',
        './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js',
        './node_modules/chartist-plugin-barlabels/dist/chartist-plugin-barlabels.min.js',
        './node_modules/xlsx/dist/xlsx.full.min.js',
        './node_modules/tableexport.jquery.plugin/tableExport.min.js'], { allowEmpty: true });

    const opensourcepos2js = gulp.src(['./node_modules/daterangepicker/daterangepicker.js',
        './public/js/imgpreview.full.jquery.js',
        './node_modules/flatpickr/dist/flatpickr.min.js',
        './node_modules/tom-select/dist/js/tom-select.complete.min.js',
        './public/js/ui.js',
        './public/js/manage_tables.js',
        './public/js/nominatim.autocomplete.js']).pipe(uglify());


    const prod1js = series(opensourcepos1js, opensourcepos2js).pipe(concat('opensourcepos.min.js'))
        .pipe(rev())
        .pipe(gulp.dest('./public/resources/'));

    return gulp.src('./app/Views/partial/header.php').pipe(inject(
        series(prod0js, prod1js), {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:prod:js -->'})).pipe(gulp.dest('./app/Views/partial'));

});


// Inject jQuery into login.php (debug mode) - reuse the jQuery file already created by debug-js
gulp.task('debug-login-js', function() {
    // Match only core jQuery (jquery-HASH.js), exclude jquery plugins (jquery-HASH.form.js, etc) and jquery-ui (jquery-ui-HASH.js)
    // Pattern: jquery-[hash].js where hash is alphanumeric - core jQuery only
    const loginDebugJs = gulp.src(['./public/resources/js/jquery-*.js', '!./public/resources/js/jquery-*.form.js', '!./public/resources/js/jquery-*.validate.js', '!./public/resources/js/jquery-ui-*.js']);
    return gulp.src('./app/Views/login.php').pipe(inject(loginDebugJs, {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:login:debug:js -->'})).pipe(gulp.dest('./app/Views'));
});

// Inject jQuery into login.php (production mode) - reuse the jQuery file already created by prod-js
gulp.task('prod-login-js', function() {
    // jQuery prod file is already in resources/jquery-*.min.js from prod-js task
    const loginProdJs = gulp.src('./public/resources/jquery-*.min.js');
    return gulp.src('./app/Views/login.php').pipe(inject(loginProdJs, {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:login:prod:js -->'})).pipe(gulp.dest('./app/Views'));
});

gulp.task('debug-config-js', function() {
    const configDebugJs = gulp.src([
        './node_modules/clipboard/dist/clipboard.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources/js'));
    return gulp.src('./app/Views/configs/manage.php').pipe(inject(configDebugJs, {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:config:debug:js -->'})).pipe(gulp.dest('./app/Views/configs'));
});

gulp.task('prod-config-js', function() {
    const configProdJs = gulp.src([
        './node_modules/clipboard/dist/clipboard.min.js'
    ]).pipe(rev()).pipe(gulp.dest('public/resources'));
    return gulp.src('./app/Views/configs/manage.php').pipe(inject(configProdJs, {addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:config:prod:js -->'})).pipe(gulp.dest('./app/Views/configs'));
});


const stylesheets = [
    './node_modules/bootstrap-icons/font/bootstrap-icons.min.css',
    './node_modules/jquery-ui-dist/jquery-ui.min.css',
    './node_modules/bootstrap-table/dist/bootstrap-table.min.css',
    './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.css',
    './node_modules/daterangepicker/daterangepicker.css',
    './node_modules/flatpickr/dist/flatpickr.min.css',
    './node_modules/tom-select/dist/css/tom-select.bootstrap5.min.css',
    './node_modules/chartist/dist/chartist.min.css',
    './node_modules/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css',
    './public/css/bootstrap.autocomplete.css',
    './public/css/invoice.css',
    './public/css/ospos_print.css',
    './public/css/ospos.css',
    './public/css/popupbox.css',
    './public/css/receipt.css',
    './public/css/register.css',
    './public/css/reports.css'
];

gulp.task('debug-css', function() {
    const css = gulp.src(stylesheets).pipe(rev()).pipe(gulp.dest('public/resources/css'));
    return gulp.src('./app/Views/partial/header.php').pipe(inject(css, {
        addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:debug:css -->'
    })).pipe(gulp.dest('./app/Views/partial'));
});

gulp.task('prod-css', function() {
    const css = gulp.src(stylesheets).pipe(cleanCSS()).pipe(concat('opensourcepos.min.css'))
        .pipe(rev()).pipe(gulp.dest('public/resources'));
    return gulp.src('./app/Views/partial/header.php').pipe(inject(css, {
        addRootSlash: false, ignorePath: '/public/', starttag: '<!-- inject:prod:css -->'
    })).pipe(gulp.dest('./app/Views/partial'));
});

gulp.task('copy-fonts', function() {
    return Promise.all([
        pipeline(gulp.src('./node_modules/bootstrap-icons/font/fonts/*', {encoding: false}), gulp.dest('public/resources/fonts')),
        pipeline(gulp.src('./node_modules/bootstrap-icons/font/fonts/*', {encoding: false}), gulp.dest('public/resources/css/fonts'))
    ]);
});

gulp.task('copy-menubar', function() {
    return Promise.all([
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/star.svg"),rename("attributes.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/bookshelf.svg"),rename("cashups.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/gear.svg"),rename("config.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/contacts.svg"),rename("customers.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/profle.svg"),rename("employees.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/compose.svg"),rename("expenses.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/clipboard.svg"),rename("expenses_categories.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/heart.svg"),rename("giftcards.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/door.svg"),rename("home.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/stack.svg"),rename("item_kits.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/shop.svg"),rename("items.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/smartphone.svg"),rename("messages.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/tools.svg"),rename("migrate.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/door.svg"),rename("office.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/dolly.svg"),rename("receivings.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/bar-chart.svg"),rename("reports.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/cart.svg"),rename("sales.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src("./node_modules/elegant-circles/svg/full-color/briefcase.svg"),rename("suppliers.svg"),gulp.dest("public/images/menubar")),
        pipeline(gulp.src('./node_modules/elegant-circles/svg/full-color/money.svg'),rename("taxes.svg"),gulp.dest("public/images/menubar"))
    ]);
});


// Run all required tasks
gulp.task('default',
    gulp.series('clean',
        'update-licenses',
        'copy-bootswatch',
        'debug-js',
        'prod-js',
        'debug-login-js',
        'prod-login-js',
        'debug-config-js',
        'prod-config-js',
        'debug-css',
        'prod-css',
        'copy-fonts',
        'copy-menubar'
    ));
