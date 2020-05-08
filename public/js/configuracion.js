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

/***/ "./resources/js/module_config/empresas.js":
/*!************************************************!*\
  !*** ./resources/js/module_config/empresas.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newEmpresa", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Empresa');
    $('#action').removeClass('updateEmpresa');
    $('#action').addClass('saveEmpresa');
    var url = currentURL + '/empresas/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveEmpresa', function (event) {
    event.preventDefault();
    var razon_social = $("#razon_social").val();
    var rfc = $("#rfc").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var cuenta = $("#cuenta").val();
    var clabe = $("#clabe").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/empresas';
    $.post(url, {
      razon_social: razon_social,
      rfc: rfc,
      calle: calle,
      numero: numero,
      colonia: colonia,
      municipio: municipio,
      cp: cp,
      cuenta: cuenta,
      clabe: clabe,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editEmpresa", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Empresa');
    $('#action').removeClass('saveEmpresa');
    $('#action').addClass('updateEmpresa');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/empresas/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-empresas tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editEmpresa").slideDown();
    $(".deleteEmpresa").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-empresas tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateEmpresa', function (event) {
    event.preventDefault();
    var razon_social = $("#razon_social").val();
    var rfc = $("#rfc").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var cuenta = $("#cuenta").val();
    var clabe = $("#clabe").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/empresas/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        razon_social: razon_social,
        rfc: rfc,
        calle: calle,
        numero: numero,
        colonia: colonia,
        municipio: municipio,
        cp: cp,
        cuenta: cuenta,
        clabe: clabe,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
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

  $(document).on('click', '.deleteEmpresa', function (event) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
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
        var url = currentURL + '/empresas/' + id;
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
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#sub_cat_" + id).slideDown();
    } else {
      $("#sub_cat_" + id).slideUp();
    }
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

/***/ "./resources/js/module_config/mensajes.js":
/*!************************************************!*\
  !*** ./resources/js/module_config/mensajes.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newMensaje", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Mensaje');
    $('#action').removeClass('updateMensaje');
    $('#action').addClass('saveMensaje');
    var url = currentURL + '/mensajes/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveMensaje', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var mensaje = $("#mensaje").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/mensajes';
    $.post(url, {
      nombre: nombre,
      mensaje: mensaje,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editMensaje", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Mensaje');
    $('#action').removeClass('saveMensaje');
    $('#action').addClass('updateMensaje');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/mensajes/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-mensajes tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editMensaje").slideDown();
    $(".deleteMensaje").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-mensajes tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateMensaje', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var mensaje = $("#mensaje").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/mensajes/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        mensaje: mensaje,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
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

  $(document).on('click', '.deleteMensaje', function (event) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
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
        var url = currentURL + '/mensajes/' + id;
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
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#sub_cat_" + id).slideDown();
    } else {
      $("#sub_cat_" + id).slideUp();
    }
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
      url = currentURL + '/usuarios';
      table = ' #table-usuarios';
    } else if (id == '2') {
      url = currentURL + '/precio-gas';
      table = ' #table-precio-gas';
    } else if (id == '3') {
      url = currentURL + '/servicios';
      table = ' #table-servicios';
    } else if (id == '4') {
      url = currentURL + '/mensajes';
      table = ' #table-mensajes';
    } else if (id == '5') {
      url = currentURL + '/menus';
      table = ' #table-menus';
    } else if (id == '6') {
      url = currentURL + '/empresas';
      table = ' #table-empresas';
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

/***/ "./resources/js/module_config/menus.js":
/*!*********************************************!*\
  !*** ./resources/js/module_config/menus.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newMenu", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Menu');
    $('#action').removeClass('updateMenu');
    $('#action').addClass('saveMenu');
    var url = currentURL + '/menus/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveMenu', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var icono = $("#icono").val();
    var modulo = $("#modulo").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/menus';
    $.post(url, {
      nombre: nombre,
      icono: icono,
      modulo: modulo,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editMenu", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Menu');
    $('#action').removeClass('saveMenu');
    $('#action').addClass('updateMenu');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/menus/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-menus tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editMenu").slideDown();
    $(".deleteMenu").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-menus tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateMenu', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var icono = $("#icono").val();
    var modulo = $("#modulo").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/menus/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        icono: icono,
        modulo: modulo,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
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

  $(document).on('click', '.deleteMenu', function (event) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
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
        var url = currentURL + '/menus/' + id;
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
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#sub_cat_" + id).slideDown();
    } else {
      $("#sub_cat_" + id).slideUp();
    }
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
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.savePrecioGas', function (event) {
    event.preventDefault();
    var precio = $("#precio").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/precio-gas';
    $.post(url, {
      precio: precio,
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

/***/ "./resources/js/module_config/servicios.js":
/*!*************************************************!*\
  !*** ./resources/js/module_config/servicios.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newServicio", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Servicio');
    $('#action').removeClass('updateServicio');
    $('#action').addClass('saveServicio');
    var url = currentURL + '/servicios/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveServicio', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var costo = $("#costo").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/servicios';
    $.post(url, {
      nombre: nombre,
      descripcion: descripcion,
      costo: costo,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editServicio", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Servicio');
    $('#action').removeClass('saveServicio');
    $('#action').addClass('updateServicio');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/servicios/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-servicios tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editServicio").slideDown();
    $(".deleteServicio").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-servicios tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateServicio', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var costo = $("#costo").val();
    var id = $("#idSeleccionado").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/servicios/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        descripcion: descripcion,
        costo: costo,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
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

  $(document).on('click', '.deleteServicio', function (event) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
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
        var url = currentURL + '/servicios/' + id;
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
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#sub_cat_" + id).slideDown();
    } else {
      $("#sub_cat_" + id).slideUp();
    }
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

/***/ "./resources/js/module_config/usuarios.js":
/*!************************************************!*\
  !*** ./resources/js/module_config/usuarios.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newUsuario", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Usuario');
    $('#action').removeClass('updateUsuario');
    $('#action').addClass('saveUsuario');
    var url = currentURL + '/usuarios/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editUsuario", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Usuario');
    $('#action').removeClass('saveUsuario');
    $('#action').addClass('updateUsuario');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/usuarios/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveUsuario', function (event) {
    event.preventDefault();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var admigas_empresas_id = $("#empresa").val();
    var rol = $("#rol").val();
    var arr = $('[name="permisos[]"]:checked').map(function () {
      return this.value;
    }).get();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/usuarios';
    $.post(url, {
      name: name,
      email: email,
      password: password,
      password_confirmation: password_confirmation,
      admigas_empresas_id: admigas_empresas_id,
      rol: rol,
      arr: arr,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
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

  $(document).on('click', '#table-usuarios tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editUsuario").slideDown();
    $(".deleteUsuario").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-usuarios tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateUsuario', function (event) {
    event.preventDefault();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_confirmation = $("#password_confirmation").val();
    var admigas_empresas_id = $("#empresa").val();
    var rol = $("#rol").val();
    var arr = $('[name="permisos[]"]:checked').map(function () {
      return this.value;
    }).get();
    var id = $("#id_user").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/usuarios/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        name: name,
        email: email,
        password: password,
        password_confirmation: password_confirmation,
        admigas_empresas_id: admigas_empresas_id,
        rol: rol,
        arr: arr,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.viewResult').html(result);
        $('.viewCreate').slideUp();
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

  $(document).on('click', '.deleteUsuario', function (event) {
    event.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
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
        var url = currentURL + '/usuarios/' + id;
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
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para mostrar los permisos por menu
   */

  $(document).on('click', '.modulo', function () {
    var id = $(this).data("value");

    if ($(this).prop('checked')) {
      $("#sub_cat_" + id).slideDown();
    } else {
      $("#sub_cat_" + id).slideUp();
    }
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
/*!********************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/module_config/menu.js ./resources/js/module_config/precio-gas.js ./resources/js/module_config/usuarios.js ./resources/js/module_config/mensajes.js ./resources/js/module_config/empresas.js ./resources/js/module_config/menus.js ./resources/js/module_config/servicios.js ***!
  \********************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\menu.js */"./resources/js/module_config/menu.js");
__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\precio-gas.js */"./resources/js/module_config/precio-gas.js");
__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\usuarios.js */"./resources/js/module_config/usuarios.js");
__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\mensajes.js */"./resources/js/module_config/mensajes.js");
__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\empresas.js */"./resources/js/module_config/empresas.js");
__webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\menus.js */"./resources/js/module_config/menus.js");
module.exports = __webpack_require__(/*! C:\Users\mchlu\Documents\Desarrollos\admigas\resources\js\module_config\servicios.js */"./resources/js/module_config/servicios.js");


/***/ })

/******/ });