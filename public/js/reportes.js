/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/module_reportes/menu.js":
/*!**********************************************!*\
  !*** ./resources/js/module_reportes/menu.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para el menu de sub categorias y mostrar la vista
   */

  $(document).on("click", ".menu", function (e) {
    e.preventDefault();
    var id = $(this).attr("id");
    console.log(id);

    if (id == '15') {
      url = currentURL + '/saldos';
      table = ' #table-saldos';
    } else if (id == '16') {
      url = currentURL + '/antiguedad';
      table = ' #table-antiguedad';
    } else if (id == '17') {
      url = currentURL + '/estado-cuenta';
      table = ' #table-estado-cuenta';
    } else if (id == '18') {
      url = currentURL + '/cargos-adicionales';
      table = ' #table-cargos-adicionales';
    } else if (id == '20') {
      url = currentURL + '/litros';
      table = ' #table-cargos-adicionales';
    } else if (id == '21') {
      url = currentURL + '/recibos-generados';
      table = ' #table-cargos-adicionales';
    } else if (id == '23') {
      url = currentURL + '/reporte-pagos-manual';
      table = ' #table-cargos-adicionales';
    }

    $.get(url, function (data, textStatus, jqXHR) {
      $(".viewResult").html(data);
      /*
      $('.viewResult' + table).DataTable({
          "lengthChange": true
      });
      */
    });
  });
});

/***/ }),

/***/ "./resources/js/module_reportes/reporte_cargos.js":
/*!********************************************************!*\
  !*** ./resources/js/module_reportes/reporte_cargos.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  $(document).on("click", ".generateReportCargo", function (e) {
    e.preventDefault();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/cargos-adicionales';
    $.post(url, {
      desde: desde,
      hasta: hasta,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.showResult').html(data);
    });
  });
});

/***/ }),

/***/ "./resources/js/module_reportes/reporte_litros.js":
/*!********************************************************!*\
  !*** ./resources/js/module_reportes/reporte_litros.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  $(document).on("click", ".generateReportLitros", function (e) {
    e.preventDefault();
    $(".exportReportLitros").slideDown();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/litros';
    $.post(url, {
      desde: desde,
      hasta: hasta,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.showResult').html(data);
    });
  });
  $(document).on("click", ".exportReportLitros", function (e) {
    e.preventDefault();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var url = currentURL + '/litros/export/' + desde + '/' + hasta;
    window.open(url);
  });
});

/***/ }),

/***/ "./resources/js/module_reportes/reporte_recibos_generados.js":
/*!*******************************************************************!*\
  !*** ./resources/js/module_reportes/reporte_recibos_generados.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  $(document).on("click", ".generateReporteRecibosGenerados", function (e) {
    e.preventDefault();
    $(".exportReporteRecibosGenerados").slideDown();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/recibos-generados';
    $.post(url, {
      desde: desde,
      hasta: hasta,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.showResult').html(data);
    });
  });
  $(document).on("click", ".exportReporteRecibosGenerados", function (e) {
    e.preventDefault();
    var desde = $("#desde").val();
    var hasta = $("#hasta").val();
    var url = currentURL + '/litros/export/' + desde + '/' + hasta;
    window.open(url);
  });
});

/***/ }),

/***/ "./resources/js/module_reportes/reporte_saldos.js":
/*!********************************************************!*\
  !*** ./resources/js/module_reportes/reporte_saldos.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  $(document).on("click", ".generateReportSaldo", function (e) {
    e.preventDefault();
    var desde = $("#desde").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/saldos';
    $.post(url, {
      desde: desde,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.showResult').html(data);
    });
  });
});

/***/ }),

/***/ 3:
/*!*******************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/module_reportes/menu.js ./resources/js/module_reportes/reporte_cargos.js ./resources/js/module_reportes/reporte_litros.js ./resources/js/module_reportes/reporte_saldos.js ./resources/js/module_reportes/reporte_recibos_generados.js ***!
  \*******************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_reportes/menu.js */"./resources/js/module_reportes/menu.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_reportes/reporte_cargos.js */"./resources/js/module_reportes/reporte_cargos.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_reportes/reporte_litros.js */"./resources/js/module_reportes/reporte_litros.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_reportes/reporte_saldos.js */"./resources/js/module_reportes/reporte_saldos.js");
module.exports = __webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_reportes/reporte_recibos_generados.js */"./resources/js/module_reportes/reporte_recibos_generados.js");


/***/ })

/******/ });