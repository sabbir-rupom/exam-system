const mix = require('laravel-mix');
const lodash = require("lodash");
const WebpackRTLPlugin = require('webpack-rtl-plugin');
const folder = {
    src: "resources/", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};

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

var third_party_assets = {
    css_js: [
        { "name": "jquery", "assets": ["./node_modules/jquery/dist/jquery.min.js"] },
        { "name": "bootstrap", "assets": ["./node_modules/bootstrap/dist/js/bootstrap.bundle.js"] },
        { "name": "metismenu", "assets": ["./node_modules/metismenu/dist/metisMenu.js"] },
        { "name": "simplebar", "assets": ["./node_modules/simplebar/dist/simplebar.js"] },
        { "name": "node-waves", "assets": ["./node_modules/node-waves/dist/waves.js"] },
        { "name": "toastr", "assets": ["./node_modules/toastr/build/toastr.min.js", "./node_modules/toastr/build/toastr.min.css"] },
        { "name": "sweetalert2", "assets": ["./node_modules/sweetalert2/dist/sweetalert2.min.js", "./node_modules/sweetalert2/dist/sweetalert2.min.css"] },
        { "name": "select2", "assets": ["./node_modules/select2/dist/js/select2.min.js", "./node_modules/select2/dist/css/select2.min.css"] },
        {
            "name": "datatables", "assets": ["./node_modules/datatables.net/js/jquery.dataTables.min.js",
                "./node_modules/datatables.net-bs4/js/dataTables.bootstrap4.js",
                "./node_modules/datatables.net-responsive/js/dataTables.responsive.min.js",
                "./node_modules/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js",
                "./node_modules/datatables.net-buttons/js/dataTables.buttons.min.js",
                "./node_modules/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.html5.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.flash.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.print.min.js",
                "./node_modules/datatables.net-buttons/js/buttons.colVis.min.js",
                "./node_modules/datatables.net-keytable/js/dataTables.keyTable.min.js",
                "./node_modules/datatables.net-select/js/dataTables.select.min.js",
                "./node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css",
                "./node_modules/datatables.net-responsive-bs4/css/responsive.bootstrap4.css",
                "./node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.css",
                "./node_modules/datatables.net-select-bs4/css/select.bootstrap4.css"]
        },
        { "name": "bootstrap-datepicker", "assets": ["./node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js", "./node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css"] },
        { "name": "datepicker", "assets": ["./node_modules/@chenfengyuan/datepicker/dist/datepicker.min.js", "./node_modules/@chenfengyuan/datepicker/dist/datepicker.min.css"] },
        { "name": "bootstrap-timepicker", "assets": ["./node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css", "./node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"] },
    ]
};

//copying third party assets
lodash(third_party_assets).forEach(function (assets, type)
{
    if (type == "css_js") {
        lodash(assets).forEach(function (plugin)
        {
            var name = plugin['name'],
                assetlist = plugin['assets'],
                css = [],
                js = [];
            lodash(assetlist).forEach(function (asset)
            {
                var ass = asset.split(',');
                for (let i = 0; i < ass.length; ++i) {
                    if (ass[i].substr(ass[i].length - 3) == ".js") {
                        js.push(ass[i]);
                    } else {
                        css.push(ass[i]);
                    }
                };
            });
            if (js.length > 0) {
                mix.combine(js, folder.dist_assets + "/libs/" + name + "/" + name + ".min.js");
            }
            if (css.length > 0) {
                mix.combine(css, folder.dist_assets + "/libs/" + name + "/" + name + ".min.css");
            }
        });
    }
});

mix.copyDirectory("./node_modules/tinymce", folder.dist_assets + "/libs/tinymce");

// copy all fonts
var out = folder.dist_assets + "fonts";
mix.copyDirectory(folder.src + "fonts", out);

// copy all images
var out = folder.dist_assets + "images";
mix.copyDirectory(folder.src + "images", out);

// copy necessary local files
out = folder.dist_assets + "files";
mix.copyDirectory(folder.src + "files", out);

mix.sass('resources/scss/icons.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/icons.css");
mix.sass('resources/scss/theme.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/theme.css");

mix.webpackConfig({
    plugins: [
        new WebpackRTLPlugin()
    ]
});


//copying demo pages related assets
var app_pages_assets = {
    js: [
        folder.src + "js/pages/form-editor.init.js",
        folder.src + "js/pages/quiz.init.js",
        folder.src + "js/pages/question-builder.init.js",
        folder.src + "js/pages/question-paper.init.js",
    ]
};

var out = folder.dist_assets + "js/";
lodash(app_pages_assets).forEach(function (assets, type)
{
    for (let i = 0; i < assets.length; ++i) {
        mix.js(assets[i], out + "pages");
    };
});

mix
    .sass('resources/scss/admin.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/admin.css")
    .sass('resources/scss/app.scss', folder.dist_assets + "css").options({ processCssUrls: false }).minify(folder.dist_assets + "css/app.css")

    mix.combine('resources/js/theme.js', folder.dist_assets + "js/theme.js")
    .js('resources/js/admin.js', folder.dist_assets + "js/admin.js")
    .combine('resources/js/common.fn.js', folder.dist_assets + "js/common.fn.js")
    .combine('resources/js/app.js', folder.dist_assets + "js/app.js");

    mix.minify([folder.dist_assets + "js/theme.js", folder.dist_assets + "js/admin.js", folder.dist_assets + "js/common.fn.js", folder.dist_assets + "js/app.js"]);
