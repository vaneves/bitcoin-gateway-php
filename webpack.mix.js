let mix = require('laravel-mix');

let bower = 'bower_components/';

mix.scripts([
  bower + 'jquery/dist/jquery.js',
  bower + 'jquery-mask-plugin/dist/jquery.mask.js',
  bower + 'jquery-validation/dist/jquery.validate.js',
  bower + 'jquery-validation/dist/additional-methods.js',
  bower + 'jquery-validation/src/localization/messages_pt_BR.js',
  bower + 'bootstrap-sass/assets/javascripts/bootstrap.js',
  bower + 'moment/moment.js',
  bower + 'moment/locale/pt-br.js',
  bower + 'bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
  bower + 'bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js',
], 'public/js/vendor.js');

// mix.styles([
//   bower + 'bootstrap-datepicker/dist/css/bootstrap-datepicker3.css',
// ], 'public/css/vendor.css');

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');


mix.copyDirectory(bower + 'font-awesome/fonts', 'public/fonts/vendor/font-awesome');
mix.copyDirectory(bower + 'bootstrap-sass/assets/fonts/bootstrap', 'public/fonts/vendor/bootstrap-sass/bootstrap');
