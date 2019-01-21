let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */


/**
 * Theme - Site - css
 *
 */

['ltr','rtl'].forEach(function (dir, index) {

    mix.styles([
        // app.min.css
        'resources/assets/theme/font-jozoor/jozoor-font.css',
        'resources/assets/theme/source-sans-pro/source-sans-pro.css',
        'resources/assets/theme/site/vendors/bootstrap/css/bootstrap.min.css',
        'resources/assets/theme/control/app/css/custom-bootstrap-margin-padding.css',
        'resources/assets/theme/site/vendors/switchery/switchery.min.css',
        'resources/assets/theme/site/vendors/font-awesome/css/font-awesome.min.css',
        'resources/assets/theme/site/vendors/themify-icons/css/themify-icons.css',
        'resources/assets/theme/site/vendors/lity/lity.min.css',
        'resources/assets/theme/site/vendors/dropify/css/dropify.min.css',
        'resources/assets/theme/site/vendors/bootstrap-select/bootstrap-select.min.css',
        'resources/assets/theme/site/vendors/bootstrap-star-rating/css/star-rating.css',
        'resources/assets/theme/site/vendors/bootstrap-star-rating/themes/krajee-svg/theme.css',
        // custom.css
        'resources/assets/theme/site/css/thejobs-' + dir + '.css',
        'resources/assets/theme/site/css/custom-' + dir + '.css'
    ], 'public/css/theme-site-' + dir + '.css').version();

});

/**
 * Theme - Site - js
 *
 */
mix.scripts([
    // app.min.js
    'resources/assets/theme/site/vendors/jquery.min.js',
    'resources/assets/theme/site/vendors/bootstrap/js/bootstrap.min.js',
    'resources/assets/theme/site/vendors/switchery/switchery.min.js',
    'resources/assets/theme/site/vendors/lity/lity.min.js',
    'resources/assets/theme/site/vendors/dropify/js/dropify.min.js',
    'resources/assets/theme/site/vendors/bootstrap-select/bootstrap-select.min.js',
    'resources/assets/theme/site/vendors/smoothscroll.js',
    'resources/assets/theme/site/vendors/jquery.mousewheel.min.js',
    'resources/assets/theme/site/vendors/matchHeight.min.js',
    'resources/assets/theme/site/vendors/jquery.countTo.js',
    'resources/assets/theme/site/vendors/jquery.highlight.js',
    'resources/assets/theme/site/vendors/bootstrap-tagsinput.min.js',
    'resources/assets/theme/site/vendors/bootstrap-star-rating/js/star-rating.js',
    'resources/assets/theme/site/vendors/bootstrap-star-rating/themes/krajee-svg/theme.js',
    // custom.js
    'resources/assets/theme/site/js/thejobs.js',
    'resources/assets/theme/site/js/custom.js'
], 'public/js/theme-site.js').version();

/**
 * Theme - Site - Extra
 *
 */

mix.copy('resources/assets/theme/site/img'   ,'public/img'   ,false);
mix.copy('resources/assets/theme/site/vendors/bootstrap-star-rating/img'   ,'public/img'   ,false);
mix.copy('resources/assets/theme/site/fonts' ,'public/fonts' ,false);
// summernote
mix.copy('resources/assets/theme/site/vendors/summernote/lang' ,'public/js/lang' ,false);
mix.copy('resources/assets/theme/site/vendors/summernote/font' ,'public/css/font' ,false);
mix.copy('resources/assets/theme/logo.png', 'public/logo.png' ,false);

/**
 * Control css
 */

var control_css = {

    font : [
        // font
        'resources/assets/theme/font-jozoor/jozoor-font.css',
        'resources/assets/theme/source-sans-pro/source-sans-pro.css',
        'resources/assets/theme/control/fontawesome/css/font-awesome.min.css',
        'resources/assets/theme/control/simple-line-icons/css/simple-line-icons.css',
        'resources/assets/theme/control/weather-icons/css/weather-icons.min.css',
    ],

    animate: [
        // animate
        'resources/assets/theme/control/loaders.css/loaders.css',
        'resources/assets/theme/control/animate.css/animate.min.css',
        'resources/assets/theme/control/whirl/whirl.css',
        'resources/assets/theme/control/sweetalert/sweetalert2.min.css',
    ],

    bootstrap: [
        'resources/assets/theme/control/app/css/bootstrap.css',
    ],

    bootstrap_rtl : [
        'resources/assets/theme/control/app/css/bootstrap-rtl.css',
    ],

    select2: [
        // select2
        'Packages/Utilities/Autocomplete/src/Assets/plugin/select2/css/select2.css',
        'Packages/Utilities/Autocomplete/src/Assets/plugin/select2-bootstrap-theme/select2-bootstrap.css',
    ],

    datatable: [
        // datatable
        'resources/assets/theme/control/custom.datatable/media/css/dataTables.bootstrap.css',
        'resources/assets/theme/control/custom.datatable/extensions/Responsive/css/responsive.bootstrap.css',
        'resources/assets/theme/control/custom.datatable/extensions/Buttons/css/buttons.bootstrap.css',
        'resources/assets/theme/control/custom.datatable/extensions/FixedColumns/css/fixedColumns.bootstrap.css',
    ],
    custom_datatable: [
        // custom datatable
        'Packages/Utilities/DataTable/src/Assets/css/ltr/datatables-custom-ltr.css',
        'Packages/Utilities/DataTable/src/Assets/css/shared/datatables-custom.css',
    ],

    custom_datatable_rtl: [
        // custom datatable
        'Packages/Utilities/DataTable/src/Assets/css/rtl/datatables-custom-rtl.css',
        'Packages/Utilities/DataTable/src/Assets/css/shared/datatables-custom.css',
    ],

    image: [
        // image
        'Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/css/fileinput.css',
    ],

    image_rtl: [
        // image
        'Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/css/fileinput.css',
        'Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/css/fileinput-rtl.css',
    ],

    cropper: [
        'Packages/Utilities/FileUpload/src/Assets/plugin/cropper/cropper.css',
    ],

    app: [
        'resources/assets/theme/control/eonasdan-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css',
        'resources/assets/theme/control/summernote/summernote.css',
    ],

    app_ltr: [
        'resources/assets/theme/control/app/css/app.css',
        'resources/assets/theme/control/app/css/control-custom-ltr.css',
    ],

    app_rtl: [
        'resources/assets/theme/control/app/css/app-rtl.css',
        'resources/assets/theme/control/app/css/control-custom-rtl.css',
    ],

    custom: [
        'resources/assets/theme/control/app/css/custom-bootstrap-margin-padding.css',
        'Packages/Utilities/GoogleMap/src/Assets/css/GMap.css',
    ]
};

mix.styles([]
    .concat(control_css.font)
    .concat(control_css.bootstrap)
    .concat(control_css.animate)
    .concat(control_css.select2)
    .concat(control_css.datatable)
    .concat(control_css.custom_datatable)
    .concat(control_css.image)
    .concat(control_css.cropper)
    .concat(control_css.app)
    .concat(control_css.app_ltr)
    .concat(control_css.custom)
,'public/css/control-all-ltr.css').version();

mix.styles([]
    .concat(control_css.font)
    .concat(control_css.bootstrap_rtl)
    .concat(control_css.animate)
    .concat(control_css.select2)
    .concat(control_css.datatable)
    .concat(control_css.custom_datatable_rtl)
    .concat(control_css.image_rtl)
    .concat(control_css.cropper)
    .concat(control_css.app)
    .concat(control_css.app_rtl)
    .concat(control_css.custom)
, 'public/css/control-all-rtl.css').version();

/**
 * Control Js
 */
var js = [
    'resources/assets/theme/control/modernizr/modernizr.custom.js',
    'resources/assets/theme/control/matchMedia/matchMedia.js',
    'resources/assets/theme/control/jquery/dist/jquery.js',

    'Packages/Utilities/DataTable/src/Assets/js/jquery-request-types.js',
    'resources/assets/theme/control/jquery-validation/dist/jquery.validate.js',

    'node_modules/lodash/lodash.js',
    'node_modules/jspath/lib/jspath.js',

    'resources/assets/theme/control/bootstrap/dist/js/bootstrap.js',
    'resources/assets/theme/control/moment/moment-with-locales.min.js',
    'resources/assets/theme/control/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js',
    'resources/assets/theme/control/jQuery-Storage-API/jquery.storageapi.js',
    'resources/assets/theme/control/jquery.easing/js/jquery.easing.js',
    'resources/assets/theme/control/animo.js/animo.js',

    'resources/assets/theme/control/slimScroll/jquery.slimscroll.min.js',
    'resources/assets/theme/control/screenfull/dist/screenfull.js',

    'resources/assets/theme/control/jquery-localize-i18n/dist/jquery.localize.js',
    'resources/assets/theme/control/app/js/demo/demo-rtl.js',

    // chart
    'resources/assets/theme/control/sparkline/index.js',
    'resources/assets/theme/control/Flot/jquery.flot.js',
    'resources/assets/theme/control/flot.tooltip/js/jquery.flot.tooltip.min.js',
    'resources/assets/theme/control/jquery.flot.resize.js',
    'resources/assets/theme/control/jquery.flot.pie.js',
    'resources/assets/theme/control/jquery.flot.time.js',
    'resources/assets/theme/control/jquery.flot.categories.js',
    'resources/assets/theme/control/flot-spline/js/jquery.flot.spline.min.js',

    'resources/assets/theme/control/jquery-classyloader/js/jquery.classyloader.min.js',
    'resources/assets/theme/control/moment/min/moment-with-locales.min.js',
    'resources/assets/theme/control/app/js/demo/demo-flot.js',

    //datatable
    'resources/assets/theme/control/custom.datatable/media/js/jquery.dataTables.js',
    'resources/assets/theme/control/custom.datatable/media/js/dataTables.bootstrap.js',

    'resources/assets/theme/control/custom.datatable/extensions/Buttons/js/dataTables.buttons.js',
    'resources/assets/theme/control/custom.datatable/extensions/Buttons/js/buttons.bootstrap.js',
    'resources/assets/theme/control/custom.datatable/extensions/Buttons/js/buttons.colVis.js',

    'resources/assets/theme/control/custom.datatable/extensions/Responsive/js/dataTables.responsive.js',
    'resources/assets/theme/control/custom.datatable/extensions/Responsive/js/responsive.bootstrap.js',
    'resources/assets/theme/control/custom.datatable/extensions/FixedColumns/js/dataTables.fixedColumns.js',
    'Packages/Utilities/DataTable/src/Assets/js/datatable.js',
    //fileinput
    'Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/js/fileinput.js',
    'Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/themes/fa/theme.js',
    //cropper
    'Packages/Utilities/FileUpload/src/Assets/plugin/cropper/cropper.js',
    //inputmask
    'resources/assets/theme/control/jquery.inputmask/dist/jquery.inputmask.bundle.js',
    // map
    'Packages/Utilities/GoogleMap/src/Assets/plugin/jQuery-gMap/jquery.gmap.min.js',
    // 'Packages/Utilities/GoogleMap/src/Assets/js/GMap.js',
    // other
    'resources/assets/theme/control/sweetalert/sweetalert2.min.js',
    'Packages/Utilities/Autocomplete/src/Assets/plugin/select2/js/select2.js',

    'resources/assets/theme/control/summernote/summernote.js',
    'resources/assets/theme/control/summernote/summernote-ext-rtl.js',
    'resources/assets/theme/control/summernote/lang/summernote-ar-AR.js',
    'resources/assets/theme/control/jquery.inputmask/dist/jquery.inputmask.bundle.js',

    'resources/assets/theme/control/app/js/app.js',
    'Packages/Utilities/FileUpload/src/Assets/file-upload.js',
];

mix.scripts(js.concat([
    'Packages/Utilities/Autocomplete/src/Assets/plugin/select2/js/i18n/en.js',
    'resources/assets/theme/control/select2/dist/js/i18n/en.js',
]), 'public/js/control-all-ltr.js').version();

mix.scripts(js.concat([
    'Packages/Utilities/Autocomplete/src/Assets/plugin/select2/js/i18n/ar.js',
    'resources/assets/theme/control/select2/dist/js/i18n/ar.js',
    'resources/assets/theme/control/jquery-validation/dist/localization/messages_ar.js',
]), 'public/js/control-all-rtl.js').version();

/**
 * control copy font,image
 */
mix.copy('resources/assets/theme/control/app/css/theme-*.css', 'public/css');

mix.copy('Packages/Utilities/GoogleMap/src/Assets/plugin/jQuery-gMap/marker_red.png', 'public/images' ,false);
mix.copy('resources/assets/theme/control/app/i18n', 'public/i18n');

mix.copy('resources/assets/theme/control/img', 'public/img' ,false);
mix.copy('Packages/Utilities/FileUpload/src/Assets/plugin/bootstrap-fileinput/img', 'public/img' ,false);

mix.copy('resources/assets/theme/control/simple-line-icons/fonts', 'public/fonts');
mix.copy('resources/assets/theme/control/fontawesome/fonts', 'public/fonts');
mix.copy('resources/assets/theme/font-jozoor/fonts', 'public/css/fonts' ,false);
mix.copy('resources/assets/theme/source-sans-pro/fonts', 'public/css/fonts' ,false);
mix.copy('resources/assets/theme/control/summernote/font', 'public/css/font' ,false);

mix.copy('Packages/Utilities/GoogleMap/src/Assets/js/GMap.js', 'public/GMap.js' ,false);


