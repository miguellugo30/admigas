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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/module_credito/conciliacion.js":
/*!*****************************************************!*\
  !*** ./resources/js/module_credito/conciliacion.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para conciliar el archivo
   */

  $(document).on("click", "#conciliar", function (e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("formConciliacion"));
    var archivoConciliacion = $("#archivoConciliar").val();

    var _token = $("input[name=_token]").val();

    formData.append("archivoConciliacion", archivoConciliacion);
    formData.append("_token", _token);
    var url = currentURL + '/conciliacion';
    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      $('.viewResult').html(data);
      /*
      Swal.fire(
          'Correcto!',
          'El registro ha sido guardado.',
          'success'
      )
      */
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Funcion para mostrar los errores de los formularios
   */

  function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $(".form-control").removeClass('is-invalid');

    for (var clave in msg) {
      $("#" + clave).addClass('is-invalid');

      if (msg.hasOwnProperty(clave)) {
        $(".print-error-msg").find("ul").append('<li>' + msg[clave][0] + '</li>');
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/module_credito/conciliacion_manual.js":
/*!************************************************************!*\
  !*** ./resources/js/module_credito/conciliacion_manual.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para conciliar el archivo
   */

  $(document).on("change", "#unidad_no_conciliado", function (e) {
    var url = currentURL + '/buscar-edificio/' + $(this).val();
    $.get(url, function (data, textStatus, xhr) {
      $('.result-search-edificio').html(data);
    });
  });
  $(document).on("change", "#edificio_no_conciliado", function (e) {
    var url = currentURL + '/buscar-depto/' + $(this).val();
    $.get(url, function (data, textStatus, xhr) {
      $('.result-search-depto').html(data);
    });
  });
  $(document).on("click", ".conciliar-button", function (e) {
    var depto_id = $('#depto_no_conciliado').val();
    var pago_id = $('input[name=pago_no_conciliado]').val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/conciliacion-manual';
    $.post(url, {
      depto_id: depto_id,
      pago_id: pago_id,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    });
  });
});

/***/ }),

/***/ "./resources/js/module_credito/menu.js":
/*!*********************************************!*\
  !*** ./resources/js/module_credito/menu.js ***!
  \*********************************************/
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

    if (id == '11') {
      url = currentURL + '/pagos-portal';
      table = ' #table-usuarios';
    } else if (id == '12') {
      url = currentURL + '/conciliacion';
      table = ' #table-precio-gas';
    } else if (id == '13') {
      url = currentURL + '/pagos-conciliados';
      table = ' #table-precio-gas';
    } else if (id == '14') {
      url = currentURL + '/pagos-no-conciliados';
      table = ' #table-precio-gas';
    } else if (id == '19') {
      url = currentURL + '/conciliacion-manual';
      table = ' #table-precio-gas';
    } else if (id == '22') {
      url = currentURL + '/pagos-manual';
      table = ' #table-precio-gas';
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

/***/ "./resources/js/module_credito/pago-manual.js":
/*!****************************************************!*\
  !*** ./resources/js/module_credito/pago-manual.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para conciliar el archivo
   */

  $(document).on("click", ".aplicar-pago-button", function (e) {
    e.preventDefault();
    var formData = new FormData(document.getElementById("formConciliacion"));
    var archivoConciliacion = $("#archivoConciliar").val();
    var importe = $("#importe").val();
    var fecha = $("#fecha").val();
    var unidad = $("#unidad_no_conciliado").val();
    var edificio = $("#edificio_no_conciliado").val();
    var depto = $("#depto_no_conciliado").val();

    var _token = $("input[name=_token]").val();

    formData.append("archivoConciliacion", archivoConciliacion);
    formData.append("importe", importe);
    formData.append("fecha", fecha);
    formData.append("unidad", unidad);
    formData.append("edificio", edificio);
    formData.append("depto", depto);
    formData.append("_token", _token);
    var url = currentURL + '/pagos-manual';
    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      cache: false,
      contentType: false,
      processData: false
    }).done(function (data) {
      $('.viewResult').html(data);
      Swal.fire('Correcto!', 'El pago se ha registro correctamente.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Funcion para mostrar los errores de los formularios
   */

  function printErrorMsg(msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display', 'block');
    $(".form-control").removeClass('is-invalid');

    for (var clave in msg) {
      $("#" + clave).addClass('is-invalid');

      if (msg.hasOwnProperty(clave)) {
        $(".print-error-msg").find("ul").append('<li>' + msg[clave][0] + '</li>');
      }
    }
  }
});

/***/ }),

/***/ 5:
/*!***************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/module_credito/menu.js ./resources/js/module_credito/conciliacion.js ./resources/js/module_credito/pago-manual.js ./resources/js/module_credito/conciliacion_manual.js ***!
  \***************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_credito/menu.js */"./resources/js/module_credito/menu.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_credito/conciliacion.js */"./resources/js/module_credito/conciliacion.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_credito/pago-manual.js */"./resources/js/module_credito/pago-manual.js");
module.exports = __webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_credito/conciliacion_manual.js */"./resources/js/module_credito/conciliacion_manual.js");


/***/ })

/******/ });