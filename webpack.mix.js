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
        'resources/js/module_config/servicios.js',
        'resources/js/module_config/lecturistas.js',
    ], 'public/js/configuracion.js')
    .js([
        'resources/js/module_edificios/zonas.js',
        'resources/js/module_edificios/unidades.js',
        'resources/js/module_edificios/condominios.js',
        'resources/js/module_edificios/tanques.js',
        'resources/js/module_edificios/departamentos.js',
        'resources/js/module_edificios/captura_lectura.js',
        'resources/js/module_edificios/recibos.js',
        'resources/js/module_edificios/cargos_adicionales.js',
    ], 'public/js/edificios.js')
    .js([
        'resources/js/module_cliente/acciones_cliente.js',
    ], 'public/js/cliente.js')
    .js([
        'resources/js/module_reportes/menu.js',
        'resources/js/module_reportes/reporte_cargos.js',
    ], 'public/js/reportes.js')
    .js([
        'resources/js/bootstrap.js',
        'resources/js/notificaciones.js',
    ], 'public/js/app.js')
    .js([
        'resources/js/module_credito/menu.js',
        'resources/js/module_credito/conciliacion.js',
        'resources/js/module_credito/conciliacion_manual.js',
    ], 'public/js/credito.js');
/*
    .sass('resources/sass/app.scss', 'public/css');
*/
