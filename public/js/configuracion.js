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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/module_config/menu.js":
/*!********************************************!*\
  !*** ./resources/js/module_config/menu.js ***!
  \********************************************/
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

    if (id == '1') {
      url = currentURL + '/precio-gas';
      table = ' #precio-gas';
    } else if (id == '2') {
      url = currentURL + '/usuarios';
      table = ' #usuarios';
    } else if (id == '3') {
      url = currentURL + '/servicios';
      table = ' #servicios';
    }

    $.get(url, function (data, textStatus, jqXHR) {
      $(".viewResult").html(data);
      $('.viewResult' + table).DataTable({
        "lengthChange": true
      });
    });
  });
});

/***/ }),

/***/ "./resources/js/module_config/precio-gas.js":
/*!**************************************************!*\
  !*** ./resources/js/module_config/precio-gas.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newPrecioGas", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Precio Gas');
    $('#action').removeClass('updatePrecioGas');
    $('#action').addClass('savePrecioGas');
    var url = currentURL + '/precio-gas/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editPrecioGas", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Precio Gas');
    $('#action').removeClass('savePrecioGas');
    $('#action').addClass('updatePrecioGas');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/precio-gas/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.savePrecioGas', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var marcar = $('input:radio[name=marcar]:checked').val();
    var mostrar_agente = $('input:radio[name=mostrar_agente]:checked').val();
    var parametrizar = $('input:radio[name=parametrizar]:checked').val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/cat_cliente';
    $.post(url, {
      nombre: nombre,
      descripcion: descripcion,
      marcar: marcar,
      mostrar_agente: mostrar_agente,
      parametrizar: parametrizar,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
      $('.viewIndex #tableEdoCli').DataTable({
        "lengthChange": true,
        "order": [[5, "asc"]]
      });
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#tableEdoCli tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editEdoCli").slideDown();
    $(".deleteEdoCli").slideDown();
    $("#idSeleccionado").val(id);
    $("#tableEdoCli tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateEdoCli', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var marcar = $('input:radio[name=marcar]:checked').val();
    var mostrar_agente = $('input:radio[name=mostrar_agente]:checked').val();
    var parametrizar = $('input:radio[name=parametrizar]:checked').val();
    var id = $("#id").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/cat_cliente/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        descripcion: descripcion,
        marcar: marcar,
        mostrar_agente: mostrar_agente,
        parametrizar: parametrizar,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
        $('.viewIndex #tableEdoCli').DataTable({
          "lengthChange": true,
          "order": [[5, "asc"]]
        });
      }
    }).done(function (data) {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido actualizado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteEdoCli', function (event) {
    event.preventDefault();
    Swal.fire({
      title: 'Estas seguro?',
      text: "Deseas eliminar el registro seleccionado!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, Eliminar!',
      cancelButtonText: 'Cancelar'
    }).then(function (result) {
      if (result.value) {
        var id = $("#idSeleccionado").val();

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = currentURL + '/cat_cliente/' + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $('.viewResult').html(result);
            $('.viewCreate').slideUp();
            $('.viewIndex #tableEdoCli').DataTable({
              "lengthChange": true,
              "order": [[5, "asc"]]
            });
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para order las categorias
   */

  $(document).on('click', '.orderignEdoCli', function (e) {
    e.preventDefault();
    $('#tituloModal').html('Ordenar Estados');
    $('#action').removeClass('saveEdoCli');
    $('#action').removeClass('updateEdoCli');
    $('#action').addClass('saveOrderEdoCli');
    var url = currentURL + "/cat_cliente/ordering";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
      $("#sortable").sortable();
    });
  });
  /**
   * Evento para editar el menu
   */

  $(document).on('click', '.saveOrderEdoCli', function (event) {
    event.preventDefault();
    $('#modal').modal('hide');
    var ordenElementos = $("#sortable").sortable("toArray").toString();

    var _token = $("input[name=_token]").val();

    var url = currentURL + "/cat_cliente/updateOrdering";
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        ordenElementos: ordenElementos,
        _token: _token
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewIndex #tableEdoCli').DataTable({
          "lengthChange": true,
          "order": [[5, "asc"]]
        });
        Swal.fire('Muy bien!', 'Los modulos han sido ordenados.', 'success');
      }
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

/***/ 0:
/*!*********************************************************************************************!*\
  !*** multi ./resources/js/module_config/menu.js ./resources/js/module_config/precio-gas.js ***!
  \*********************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/html/admigas2/resources/js/module_config/menu.js */"./resources/js/module_config/menu.js");
module.exports = __webpack_require__(/*! /var/www/html/admigas2/resources/js/module_config/precio-gas.js */"./resources/js/module_config/precio-gas.js");


/***/ })

/******/ });