const mix = require('laravel-mix');

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

mix.js([
    'resources/js/module_config/menu.js',
    'resources/js/module_config/precio-gas.js',
    'resources/js/module_config/usuarios.js',
    'resources/js/module_config/mensajes.js',
    'resources/js/module_config/empresas.js',
    'resources/js/module_config/menus.js',
], 'public/js/configuracion.js');
/*
    .sass('resources/sass/app.scss', 'public/css');
*/
