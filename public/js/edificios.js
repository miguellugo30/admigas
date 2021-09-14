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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/module_edificios/captura_lectura.js":
/*!**********************************************************!*\
  !*** ./resources/js/module_edificios/captura_lectura.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".capturarLecturas", function (e) {
    e.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    $('.list-deptos').slideUp();
    var url = currentURL + '/captura-lecturas/' + admigas_condominios_id;
    $.get(url, function (data, textStatus, jqXHR) {
      $(".list-deptos-capture").html(data);
      $(".list-deptos-capture").slideDown();
    });
  });
  /**
   * Evento para saber si la lectura actual es menor a la anterior
   */

  $(document).on("change", ".nueva_lectura", function (e) {
    var numero = parseFloat($(this).data('posicion'));
    var lectura = parseFloat($(this).data("lectura_anterior"));
    var cantidad = $(this).val();
    var diferencia = Math.floor((cantidad - lectura) * 1000) / 1000;
    $(".diferencia_" + numero).html(diferencia);

    if (cantidad < lectura) {
      Swal.fire('Tenemos un problema!', 'La Lectura Actual es menor a la anterior.', 'warning');

      if (!lectura > 9500 && cantidad < 1000) {
        $(".mensaje" + numero).html("La lectura Actual es menor");
      }
    } else {
      $(".mensaje" + numero).html(" ");
    }
  });
  /**
   * Evento para cuando se pierda el foco del cursor
   * se iguale la lectura
   */

  $(document).on("blur", ".nueva_lectura", function (e) {
    var cantidad = parseFloat($(this).val());
    var lectura = parseFloat($(this).data("lectura_anterior"));

    if (isNaN(cantidad)) {
      $(this).val(lectura);
    }

    ;
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveLecturas', function (event) {
    event.preventDefault();
    var fecha_lectura = $("#fecha_lectura").val();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var data = $('#formLecturasCapture').serializeArray();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/captura-lecturas';

    if (fecha_lectura == null || fecha_lectura == '') {
      Swal.fire('Error!', 'Debe ingresar una Fecha de Lectura.', 'error');
      $("#fecha_lectura").addClass('is-invalid');
    } else {
      $.post(url, {
        data: data,
        fecha_lectura: fecha_lectura,
        admigas_condominios_id: admigas_condominios_id,
        _token: _token
      }, function (data, textStatus, xhr) {
        $('.viewResult').html(data);
      }).done(function () {
        Swal.fire('Correcto!', 'Las lecturas sean guardado correctamente.', 'success');
      }).fail(function (data) {
        printErrorMsg(data.responseJSON.errors);
      });
    }
  });
  /**
   * Evento para mostrar regresar a zonas
   */

  $(document).on('click', '.returnCondominio', function (event) {
    event.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var url = currentURL + "/condominios/" + admigas_condominios_id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.viewResult').html(result);
        $('#table-departamentos').DataTable({
          "responsive": true,
          "autoWidth": false
        });
      }
    });
  });
  /**
   * Funcion para sincronizar las fotos y lecturas
   * desde Google Drive
   */

  $(document).on('click', '.sincronizarLecturas', function (event) {
    event.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var fecha_lectura = $("#fecha_lectura").val();

    var _token = $("input[name=_token]").val();

    if (fecha_lectura == null || fecha_lectura == '') {
      Swal.fire('Error!', 'Debe ingresar una Fecha de Lectura.', 'error');
      $("#fecha_lectura").addClass('is-invalid');
    } else {
      var url = currentURL + "/sincroniza-lecturas";
      $.post(url, {
        admigas_condominios_id: admigas_condominios_id,
        fecha_lectura: fecha_lectura,
        _token: _token
      }, function (data, textStatus, xhr) {
        $(".list-deptos-capture").html(data);
        $("#fecha_lectura").val(fecha_lectura);
      }).done(function () {
        Swal.fire('Correcto!', 'Las lecturas sean descargado correctamente.', 'success');
      }).fail(function (data) {
        printErrorMsg(data.responseJSON.errors);
      });
    }
  });
  /**
   * Funcion para actualizar el excel en Google Drive
   */

  $(document).on('click', '.actualizarExcel', function (event) {
    event.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + "/actualizar-excel";
    $.post(url, {
      admigas_condominios_id: admigas_condominios_id,
      _token: _token
    }, function (data, textStatus, xhr) {//$(".list-deptos-capture").html(data);
      //  $("#fecha_lectura").val(fecha_lectura);
    }).done(function () {
      Swal.fire('Correcto!', 'Se ha actualizado el Excel.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Funcion para sincronizar las lecturas iniciales de Google Drive
   */

  $(document).on('click', '.sincronizarFotosIniciales', function (event) {
    event.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + "/sincronizar-fotos-iniciales";
    Swal.fire({
      title: 'Fecha de lectura inicial',
      input: 'text',
      inputAttributes: {
        autocapitalize: 'off'
      },
      inputPlaceholder: 'DD/MM/YYYY',
      showCancelButton: true,
      confirmButtonText: 'Sincronizar',
      showLoaderOnConfirm: true
    }).then(function (result) {
      $.post(url, {
        admigas_condominios_id: admigas_condominios_id,
        fecha_lectura: result.value,
        _token: _token
      }, function (data, textStatus, xhr) {//$(".list-deptos-capture").html(data);
        //  $("#fecha_lectura").val(fecha_lectura);
      }).done(function () {
        Swal.fire('Correcto!', 'Se han sincronizado las fotos iniciales.', 'success');
      }).fail(function (data) {
        printErrorMsg(data.responseJSON.errors);
      });
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
      $("input[name='lectura']").addClass('is-invalid');

      if (msg.hasOwnProperty(clave)) {
        $(".print-error-msg").find("ul").append('<li>' + msg[clave][0] + '</li>');
      }
    }
  }
});

/***/ }),

/***/ "./resources/js/module_edificios/cargos_adicionales.js":
/*!*************************************************************!*\
  !*** ./resources/js/module_edificios/cargos_adicionales.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".cargosAdicionales", function (e) {
    e.preventDefault();
    $('#modal-condominio #tituloModal').html('Cargos Adicionales');
    $('#modal-condominio #action').removeClass('updateCargosAdicionales');
    $('#modal-condominio #action').addClass('saveCargosAdicionales');
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var url = currentURL + '/create-cargos-adicionales/' + admigas_condominios_id;
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-condominio').modal('show');
      $("#modal-condominio #modal-body").html(data);
    });
  });
  /**
   * Evento para clonar finas de la tabla
   */

  $(document).on('click', '#addDeptoCargos', function (event) {
    var clickID = $(".tableNewForm tbody tr.clonar:last").attr('id').replace('tr_', ''); // Genero el nuevo numero id

    var newID = parseInt(clickID) + 1;
    var IDInput = ['depto']; //ID de los inputs dentro de la fila

    fila = $(".tableNewForm tbody tr:eq()").clone().appendTo(".tableNewForm"); //Clonamos la fila

    for (var i = 0; i < IDInput.length; i++) {
      fila.find('#' + IDInput[i]).attr('name', IDInput[i] + "_" + newID); //Cambiamos el nombre de los campos de la fila a clonar
    }

    fila.find('.btn-danger').css('display', 'initial');
    fila.attr("id", 'tr_' + newID);
  });
  /**
   * Evento para eliminar una fila de la tabla
   */

  $(document).on('click', '.tr_clone_remove', function () {
    var tr = $(this).closest('tr');
    tr.remove();
  });
  /**
   * Evento para guardar
   */

  $(document).on('click', '.saveCargosAdicionales', function (event) {
    event.preventDefault();
    var servicio = $("#servicio").val();
    var plazo = $("#plazo").val();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var dataForm = $("#formCargosCapture").serializeArray();
    var data = {};
    $(dataForm).each(function (index, obj) {
      data[obj.name] = obj.value;
    });

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/cargos-adicionales';
    $.post(url, {
      dataForm: data,
      servicio: servicio,
      plazo: plazo,
      admigas_condominios_id: admigas_condominios_id,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-condominio').modal('hide');
      $('.list-deptos-capture').html(data);
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar los cargos adicionales de un departamento
   */

  $(document).on("click", ".viewCargo", function (e) {
    e.preventDefault();
    $('#modal-condominio #tituloModal').html('Cargos Adicionales al Departamento');
    $('#modal-condominio #action').removeClass('updateCargosAdicionales');
    $('#modal-condominio #action').addClass('saveCargosAdicionales');
    var id_depto = $(this).data('id_depto');
    var url = currentURL + '/cargos-adicionales/' + id_depto;
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-condominio').modal('show');
      $("#modal-condominio #modal-body").html(data);
    });
  });
  /**
   * Evento para eliminar un cargo
   */

  $(document).on('click', '.deleteCargoAdicional', function (event) {
    event.preventDefault();
    var cargo_id = $(this).data('id-cargo');
    var admigas_condominios_id = $("#admigas_condominios_id").val();

    var _token = $("input[name=_token]").val();

    var _method = "DELETE";
    var url = currentURL + '/cargos-adicionales/' + cargo_id;
    $.post(url, {
      cargo_id: cargo_id,
      admigas_condominios_id: admigas_condominios_id,
      _method: _method,
      _token: _token
    }, function (data, textStatus, xhr) {
      $("#tr_" + cargo_id).remove();
      $('.list-deptos-capture').html(data);
      Swal.fire('Correcto!', 'El cargo ha sido eleminado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
});

/***/ }),

/***/ "./resources/js/module_edificios/condominios.js":
/*!******************************************************!*\
  !*** ./resources/js/module_edificios/condominios.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newEdificio", function (e) {
    e.preventDefault();
    $('#modal-condominio #tituloModal').html('Nuevo Edificio');
    $('#modal-condominio #action').removeClass('updateEdificio');
    $('#modal-condominio #action').addClass('saveEdificio');
    var admigas_unidades_id = $("#admigas_unidades_id").val();
    var url = currentURL + '/condominios-create/' + admigas_unidades_id;
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-condominio').modal('show');
      $("#modal-condominio #modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveEdificio', function (event) {
    event.preventDefault();
    var tipo = $("#tipo").val();
    var nombre = $("#nombre").val();
    var descuento = $("#descuento").val();
    var factor = $("#factor").val();
    var gasto_admin = $("#gasto_admin").val();
    var fecha_lectura = $("#fecha_lectura").val();
    var admigas_unidades_id = $("#admigas_unidades_id").val();
    var tanques = $('[name="tanques[]"]:checked').map(function () {
      return this.value;
    }).get();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/condominios';

    if (tanques.length == 0) {
      Swal.fire('Error!', 'Debe vincular por lo menos un tanque al edificio.', 'error');
    } else {
      $.post(url, {
        tipo: tipo,
        nombre: nombre,
        descuento: descuento,
        factor: factor,
        gasto_admin: gasto_admin,
        fecha_lectura: fecha_lectura,
        tanques: tanques,
        admigas_unidades_id: admigas_unidades_id,
        _token: _token
      }, function (data, textStatus, xhr) {
        $('.sidebar').html(data);
      }).done(function () {
        $("#modal-edificios #modal-body").html('');
        $('.modal-backdrop ').css('display', 'none');
        $('#modal-edificios').modal('hide');
        Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
      }).fail(function (data) {
        printErrorMsg(data.responseJSON.errors);
      });
    }
  });
  /**
   * Evento para mostrar el una registro
   */

  $(document).on('click', '.viewEdificio', function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var url = currentURL + "/condominios/" + id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.viewResult').html(result);
        $('#table-departamentos').DataTable({
          "responsive": true,
          "autoWidth": false
        });
      }
    });
  });
  /**
   * Evento para mostrar regresar a zonas
   */

  $(document).on('change', '#tipo', function (event) {
    if ($(this).val() == 1) {
      $(".tipo-punto-venta").slideUp();
    } else {
      $(".tipo-punto-venta").slideDown();
    }
  });
  /**
   * Eliminamos las clases agregadas dinamicamente
   */

  $("#modal-edificios").on("hide.bs.modal", function () {
    $('#modal-condominio #action').removeClass('updateEdificio');
    $('#modal-condominio #action').removeClass('saveEdificio');
  });
  /**
   * Evento para mostrar el formulario de edicion
   */

  $(document).on("click", ".editCondominio", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Condominio');
    $('#modal-condominio #action').removeClass('saveEdificio');
    $('#modal-condominio #action').addClass('updateEdificio');
    var id = $('#id_condominio').val();
    var url = currentURL + "/condominios/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-condominio').modal('show');
      $("#modal-condominio #modal-body").html(data);
    });
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateEdificio', function (event) {
    event.preventDefault();
    var tipo = $("#tipo").val();
    var nombre = $("#nombre").val();
    var descuento = $("#descuento").val();
    var factor = $("#factor").val();
    var gasto_admin = $("#gasto_admin").val();
    var fecha_lectura = $("#fecha_lectura").val();
    var id = $("#id_condominio").val();
    var tanques = $('[name="tanques[]"]:checked').map(function () {
      return this.value;
    }).get();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/condominios/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        tipo: tipo,
        nombre: nombre,
        descuento: descuento,
        factor: factor,
        gasto_admin: gasto_admin,
        fecha_lectura: fecha_lectura,
        tanques: tanques,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        var id_unidad = $("#admigas_unidades_id").val();
        var url = currentURL + "/unidades/" + id_unidad;
        $.ajax({
          url: url,
          type: 'GET',
          success: function success(result) {
            $('.sidebar').html(result);
          }
        });
        var urlb = currentURL + "/condominios/" + id;
        $.ajax({
          url: urlb,
          type: 'GET',
          success: function success(result) {
            $('.viewResult').html(result);
            $('#table-departamentos').DataTable({
              "responsive": true,
              "autoWidth": false
            });
          }
        });
      }
    }).done(function (data) {
      $("#modal-edificios #modal-body").html('');
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-condominio').modal('hide');
      /*
      Swal.fire(
          'Correcto!',
          'El registro ha sido actualizado.',
          'success'
      )
      */
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar un registro
   */

  $(document).on('click', '.deleteCondominio', function (event) {
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
        var id = $('#id_condominio').val();

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = currentURL + '/condominios/' + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $('.viewResult').html(result);
            var id_unidad = $("#admigas_unidades_id").val();
            var url = currentURL + "/unidades/" + id_unidad;
            $.ajax({
              url: url,
              type: 'GET',
              success: function success(result) {
                $('.sidebar').html(result);
              }
            });
          }
        });
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

/***/ "./resources/js/module_edificios/departamentos.js":
/*!********************************************************!*\
  !*** ./resources/js/module_edificios/departamentos.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newDepartamento", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Departamento');
    $('#action').removeClass('updateDepartamento');
    $('#action').addClass('saveDepartamento');
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var url = currentURL + '/departamentos/create/' + admigas_condominios_id;
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para completar la referencia
   */

  $(document).on('blur', '#numero_departamento', function (event) {
    var num_depto = $(this).val();
    var referencia = $("#referencia_digitos").val();
    var clasificacion = $('input:radio[name=clasificacion]:checked').val();
    var medio = $('input:radio[name=medio]:checked').val();

    if (clasificacion == 'propio') {
      clas = 'P';
    } else if (clasificacion == 'arrendado') {
      clas = 'A';
    }

    if (medio == 'digital') {
      med = 'E';
    } else if (medio == 'fisico') {
      med = 'I';
    }

    ref = referencia + num_depto.padStart(4, '0') + clas + med;
    $("#basic-addon1").text(ref);
    $("#referencia_digitos").val(ref);
  });
  $(document).on('change', 'input:radio[name=clasificacion]', function (event) {
    var clasificacion = $(this).val();
    var referencia = $("#referencia_digitos").val();

    if (clasificacion == 'propio') {
      ref = referencia.replace('A', 'P');
    } else if (clasificacion == 'arrendado') {
      ref = referencia.replace('P', 'A');
    } //ref = referencia + num_depto.padStart(4, '0') + clas + med;


    $("#basic-addon1").text(ref);
    $("#referencia_digitos").val(ref);
  });
  $(document).on('change', 'input:radio[name=medio]', function (event) {
    var clasificacion = $(this).val();
    var referencia = $("#referencia_digitos").val();

    if (clasificacion == 'digital') {
      ref = referencia.replace('I', 'E');
      $("#gasto_admin").val(10);
    } else if (clasificacion == 'fisico') {
      ref = referencia.replace('E', 'I');
      $("#gasto_admin").val(15);
    } //ref = referencia + num_depto.padStart(4, '0') + clas + med;


    $("#basic-addon1").text(ref);
    $("#referencia_digitos").val(ref);
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveDepartamento', function (event) {
    event.preventDefault();
    var numero_departamento = $("#numero_departamento").val();
    var referencia_digitos = $("#referencia_digitos").val();
    var digito_banco = $("#digito_banco").val();
    var nombre = $("#nombre").val();
    var apellido_paterno = $("#apellido_paterno").val();
    var apellido_materno = $("#apellido_materno").val();
    var telefono = $("#telefono").val();
    var celular = $("#celular").val();
    var correo_electronico = $("#correo_electronico").val();
    var tipo = $("#tipo").val();
    var marca = $("#marca").val();
    var numero_serie = $("#numero_serie").val();
    var lectura = $("#lectura").val();
    var fecha_lectura = $("#fecha_lectura").val();
    var clasificacion = $("input:radio[name=clasificacion]").val();
    var medio = $("input:radio[name=medio]:checked").val();
    var gasto_admin = $("#gasto_admin").val();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var numero_referencia = referencia_digitos + digito_banco;

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/departamentos';
    $.post(url, {
      numero_departamento: numero_departamento,
      numero_referencia: numero_referencia,
      nombre: nombre,
      apellido_paterno: apellido_paterno,
      apellido_materno: apellido_materno,
      telefono: telefono,
      celular: celular,
      correo_electronico: correo_electronico,
      tipo: tipo,
      marca: marca,
      numero_serie: numero_serie,
      lectura: lectura,
      fecha_lectura: fecha_lectura,
      clasificacion: clasificacion,
      medio: medio,
      gasto_admin: gasto_admin,
      admigas_condominios_id: admigas_condominios_id,
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

  $(document).on("click", ".editDepartamento", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Departamento');
    $('#action').removeClass('saveDepartamento');
    $('#action').addClass('updateDepartamento');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/departamentos/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-departamentos tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editDepartamento").slideDown();
    $(".deleteDepartamento").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-departamentos tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateDepartamento', function (event) {
    event.preventDefault();
    var numero_departamento = $("#numero_departamento").val();
    var numero_referencia = $("#numero_referencia").val();
    var nombre = $("#nombre").val();
    var apellido_paterno = $("#apellido_paterno").val();
    var apellido_materno = $("#apellido_materno").val();
    var telefono = $("#telefono").val();
    var celular = $("#celular").val();
    var correo_electronico = $("#correo_electronico").val();
    var admigas_departamentos_id = $("#admigas_departamentos_id").val();
    var id_condominio = $("#id_condominio").val();
    var clasificacion = $("input:radio[name=clasificacion]").val();
    var medio = $("input:radio[name=medio]:checked").val();
    var gasto_admin = $("#gasto_admin").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/departamentos/' + admigas_departamentos_id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        numero_departamento: numero_departamento,
        numero_referencia: numero_referencia,
        nombre: nombre,
        apellido_paterno: apellido_paterno,
        apellido_materno: apellido_materno,
        telefono: telefono,
        celular: celular,
        correo_electronico: correo_electronico,
        clasificacion: clasificacion,
        medio: medio,
        gasto_admin: gasto_admin,
        admigas_departamentos_id: admigas_departamentos_id,
        id_condominio: id_condominio,
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
   * Evento para ver el detalle de un departamento
   */

  $(document).on("dblclick", "#table-departamentos tbody tr", function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $('.list-deptos').slideUp();
    var url = currentURL + '/departamentos/' + id;
    $.get(url, function (data, textStatus, jqXHR) {
      $(".list-deptos-capture").html(data);
      $(".list-deptos-capture").slideDown();
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteDepartamento', function (event) {
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
        var url = currentURL + '/departamentos/' + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $('.viewResult').html(result);
            $('#table-departamentos').DataTable({
              "responsive": true,
              "autoWidth": false
            });
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
      }
    });
  });
  /**
   * Evento para visualizar los recibos
   */

  $(document).on('click', '.viewRecibo', function (event) {
    var departamentos_id = $("#idSeleccionado").val();
    var recibos_id = $(this).data('id_recibo');
    console.log(departamentos_id + " " + recibos_id);
    var url = currentURL + '/departamentos/show_recibo/' + departamentos_id + '/' + recibos_id;
    window.open(url, '_blank');
  });
  /**
   * Eliminamos las clases agregadas dinamicamente
   */

  $("#modal-edificios").on("hide.bs.modal", function () {
    $('#action').removeClass('saveDepartamento');
    $('#action').removeClass('updateDepartamento');
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

/***/ "./resources/js/module_edificios/recibos.js":
/*!**************************************************!*\
  !*** ./resources/js/module_edificios/recibos.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevos recibos
   */

  $(document).on("click", ".generarRecibos", function (e) {
    e.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    $('.list-deptos').slideUp();
    var url = currentURL + '/generar-recibos/' + admigas_condominios_id;
    $.get(url, function (data, textStatus, jqXHR) {
      $(".list-deptos-capture").html(data);
      $(".list-deptos-capture").slideDown();
    });
  });
  /**
   * Evento para generar recibos
   */

  $(document).on('click', '.generateRecibos', function (event) {
    event.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var fecha_recibo = $("#fecha_recibo").val();
    var mensaje = $("#mensaje").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/recibos';

    if (fecha_recibo == "") {
      Swal.fire('Tenemos un problema!', 'No se ha seleccionado una fecha de recibo.', 'error');
    } else {
      $.post(url, {
        admigas_condominios_id: admigas_condominios_id,
        fecha_recibo: fecha_recibo,
        mensaje: mensaje,
        _token: _token
      }, function (data, textStatus, xhr) {
        $('.viewResult').html(data);
        $('#table-departamentos').DataTable({
          "responsive": true,
          "autoWidth": false
        });
      }).done(function () {
        Swal.fire('Correcto!', 'Se ha generado correctamente los recibos.', 'success');
      }).fail(function (data) {
        printErrorMsg(data.responseJSON.errors);
      });
    }
  });
  /**
   * Evento para imprimir los recibos
   */

  $(document).on("click", ".sendRecibos", function (e) {
    e.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var url = currentURL + '/enviar-recibos/' + admigas_condominios_id;
    $.get(url, function (data, textStatus, jqXHR) {});
  });
  /**
   * Evento para enviar los recibos
   */

  $(document).on("click", ".printRecibos", function (e) {
    e.preventDefault();
    var admigas_condominios_id = $("#admigas_condominios_id").val();
    var url = currentURL + '/recibos/' + admigas_condominios_id;
    window.open(url, '_blank');
    return false;
  });
  /**
   * Evento para cancelar todos los recibos
   */

  $(document).on("click", ".cancelAllRecibos", function (e) {
    e.preventDefault();
    Swal.fire({
      title: '¿Estas seguro?',
      text: "Deseas eliminar los últimos recibos generados, esta acción es irreversible!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, deseo eliminarlos!',
      cancelButtonText: 'No, cancelar'
    }).then(function (result) {
      if (result.value) {
        Swal.fire({
          title: 'Motivo de cancelación',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Cancelar Recibos',
          showLoaderOnConfirm: true
        }).then(function (result) {
          var admigas_condominios_id = $("#admigas_condominios_id").val();
          var url = currentURL + '/recibos/' + admigas_condominios_id;
          var _method = "DELETE";

          var _token = $("input[name=_token]").val();

          $.post(url, {
            cancel: 1,
            motivo_cancelacion: result.value,
            _method: _method,
            _token: _token
          }, function (data, textStatus, xhr) {
            $(".list-deptos-capture").html(data);
            $(".list-deptos-capture").slideDown();
          }).done(function () {
            Swal.fire('Eliminado!', 'Se ha eliminado correctamente los recibos.', 'success');
          }).fail(function (data) {
            printErrorMsg(data.responseJSON.errors);
          });
        });
      }
    });
  });
  /**
   * Evento para mostrar el boton de cancelar
   */

  $(document).on("click", ".cancelOneRecibo", function (e) {
    e.preventDefault();
    $('.reciboCancel').css('display', 'block');
  });
  /**
   * Evento para cancelar un solo recibo
   */

  $(document).on("click", ".reciboCancelOne", function (e) {
    e.preventDefault();
    var departamento_id = $(this).data('id-depto');
    Swal.fire({
      title: '¿Estas seguro?',
      text: "Deseas eliminar el recibo seleccionado, esta acción te permitirá crear un nuevo recibo con la información corregida!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, deseo eliminarlo!',
      cancelButtonText: 'No, cancelar'
    }).then(function (result) {
      if (result.value) {
        $('#tituloModal').html('Editar Recibo');
        $('#action').addClass('updateRecibo');
        var url = currentURL + '/recibos/' + departamento_id + "/edit";
        $.get(url, function (data, textStatus, jqXHR) {
          $('#modal').modal('show');
          $("#modal-body").html(data);
        });
      }
    });
  });
});

/***/ }),

/***/ "./resources/js/module_edificios/tanques.js":
/*!**************************************************!*\
  !*** ./resources/js/module_edificios/tanques.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario editar modulo
   */

  $(document).on('click', '#table-tanques tbody tr', function (event) {
    event.preventDefault();
    var id = $(this).data("id");
    $(".editTanque").slideDown();
    $(".deleteTanque").slideDown();
    $("#idSeleccionado").val(id);
    $("#table-tanques tbody tr").removeClass('table-primary');
    $(this).addClass('table-primary');
  });
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newTanque", function (e) {
    e.preventDefault();
    $('#modal-edificios #tituloModal').html('Nuevo Tanque');
    $('#modal-edificios #action').removeClass('updateTanque');
    $('#modal-edificios #action').addClass('saveTanque');
    var url = currentURL + '/tanques/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-edificios').modal('show');
      $("#modal-edificios #modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveTanque', function (event) {
    event.preventDefault();
    var num_serie = $("#num_serie").val();
    var marca = $("#marca").val();
    var fecha_fabricacion = $("#fecha_fabricacion").val();
    var estado_al_recibir = $("#estado_al_recibir").val();
    var capacidad = $("#capacidad").val();
    var inventario = $('input:radio[name=inventario]:checked').val();
    var admigas_unidades_id = $("#admigas_unidades_id").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/tanques';
    $.post(url, {
      num_serie: num_serie,
      marca: marca,
      fecha_fabricacion: fecha_fabricacion,
      estado_al_recibir: estado_al_recibir,
      capacidad: capacidad,
      inventario: inventario,
      admigas_unidades_id: admigas_unidades_id,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-edificios').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el formulario de edicion de un canal
   */

  $(document).on("click", ".editTanque", function (e) {
    e.preventDefault();
    $('#modal-file-foto #tituloModal').html('Editar Tanque');
    $('#modal-file-foto #action').removeClass('saveTanque');
    $('#modal-file-foto #action').addClass('updateTanque');
    var id = $("#idSeleccionado").val();
    var url = currentURL + "/tanques/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-file-foto').modal('show');
      $("#modal-file-foto #modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.updateTanque', function (event) {
    event.preventDefault();
    var tanque_id = $("#tanque_id").val();
    var admigas_unidades_id = $("#admigas_unidades_id").val();
    var num_serie = $("#num_serie").val();
    var marca = $("#marca").val();
    var fecha_fabricacion = $("#fecha_fabricacion").val();
    var estado_al_recibir = $("#estado_al_recibir").val();
    var capacidad = $("#capacidad").val();
    var inventario = $('input:radio[name=inventario]:checked').val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/tanques/' + tanque_id;
    $.post(url, {
      tanque_id: tanque_id,
      admigas_unidades_id: admigas_unidades_id,
      num_serie: num_serie,
      marca: marca,
      fecha_fabricacion: fecha_fabricacion,
      estado_al_recibir: estado_al_recibir,
      capacidad: capacidad,
      inventario: inventario,
      _token: _token,
      _method: 'PUT'
    }, function (data, textStatus, xhr) {
      $('.viewResult').html(data);
    }).done(function () {
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-file-foto').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el una registro
   */

  $(document).on('click', '.viewTanque', function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var url = currentURL + "/tanques/" + id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.sidebar').html(result);
      }
    });
  });
  /**
   * Evento para eliminar el modulo
   */

  $(document).on('click', '.deleteTanque', function (event) {
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
        var url = currentURL + '/tanques/' + id;
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
   * Eliminamos las clases agregadas dinamicamente
   */

  $("#modal-edificios").on("hide.bs.modal", function () {
    $('#action').removeClass('updateTanque');
    $('#action').removeClass('saveTanque');
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

/***/ "./resources/js/module_edificios/unidades.js":
/*!***************************************************!*\
  !*** ./resources/js/module_edificios/unidades.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newUnidad", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nueva Unidad');
    $('#action').removeClass('updateUnidad');
    $('#action').addClass('saveUnidad');
    var url = currentURL + '/unidades/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-edificios').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveUnidad', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var estado = $("#estado").val();
    var entre_calles = $("#entre_calles").val();
    var precio_gas = $("#precio_gas").val();
    var admigas_zonas_id = $("#admigas_zonas_id").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/unidades';
    $.post(url, {
      nombre: nombre,
      calle: calle,
      numero: numero,
      colonia: colonia,
      municipio: municipio,
      cp: cp,
      estado: estado,
      entre_calles: entre_calles,
      precio_gas: precio_gas,
      admigas_zonas_id: admigas_zonas_id,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.sidebar').html(data);
    }).done(function () {
      $("#modal-body").html('');
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-edificios').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar un registro
   */

  $(document).on('click', '.viewUnidad', function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var url = currentURL + "/unidades/" + id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.sidebar').html(result);
      }
    });
    var urlb = currentURL + "/unidades-breadcrumb/" + id;
    $.ajax({
      url: urlb,
      type: 'GET',
      success: function success(result) {
        $('.breadcrumb').html(result);
      }
    });
    var urlc = currentURL + "/tanques/" + id;
    $.ajax({
      url: urlc,
      type: 'GET',
      success: function success(result) {
        $('.viewResult').html(result);
      }
    });
  });
  /**
   * Evento para mostrar regresar a zonas
   */

  $(document).on('click', '.returnUnidad', function (event) {
    event.preventDefault();
    $('.viewResult').html("");
    var admigas_zonas_id = $("#admigas_zonas_id").val();
    var url = currentURL + "/zonas-unidades/" + admigas_zonas_id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.sidebar').html(result);
      }
    });
    /**
     * Mostrar el breacrumd
     */

    var urlb = currentURL + "/zonas-breadcrumb/" + admigas_zonas_id;
    $.ajax({
      url: urlb,
      type: 'GET',
      success: function success(result) {
        $('.breadcrumb').html(result);
      }
    });
  });
  /**
   * Eliminamos las clases agregadas dinamicamente
   */

  $("#modal-edificios").on("hide.bs.modal", function () {
    $('#action').removeClass('updateUnidad');
    $('#action').removeClass('saveUnidad');
  });
  /**
   * Evento para mostrar el formulario de edicion
   */

  $(document).on("click", ".editUnidad", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Unidad');
    $('#action').removeClass('saveUnidad');
    $('#action').addClass('updateUnidad');
    var id = $('.unidad').data('unidad-id');
    var url = currentURL + "/unidades/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-edificios').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateUnidad', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var calle = $("#calle").val();
    var numero = $("#numero").val();
    var colonia = $("#colonia").val();
    var municipio = $("#municipio").val();
    var cp = $("#cp").val();
    var estado = $("#estado").val();
    var entre_calles = $("#entre_calles").val();
    var precio_gas = $("#precio_gas").val();
    var id = $("#unidad_id").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/unidades/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        calle: calle,
        numero: numero,
        colonia: colonia,
        municipio: municipio,
        cp: cp,
        estado: estado,
        entre_calles: entre_calles,
        precio_gas: precio_gas,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $('.breadcrumb').html(result);
      }
    }).done(function (data) {
      $("#modal-body").html('');
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-edificios').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido actualizado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para eliminar un registro
   */

  $(document).on('click', '.deleteUnidad', function (event) {
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
        var id = $('.unidad').data('unidad-id');

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = currentURL + '/unidades/' + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            var id = $('.returnUnidad').data('zona-id');
            var url = currentURL + "/zonas/" + id;
            $.ajax({
              url: url,
              type: 'GET',
              success: function success(result) {
                $('.sidebar').html(result);
              }
            });
            /**
             * Mostrar el breacrumd
             */

            var urlb = currentURL + "/zonas-breadcrumb/" + id;
            $.ajax({
              url: urlb,
              type: 'GET',
              success: function success(result) {
                $('.breadcrumb').html(result);
              }
            });
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
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

/***/ "./resources/js/module_edificios/zonas.js":
/*!************************************************!*\
  !*** ./resources/js/module_edificios/zonas.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var currentURL = window.location.href;
  $.get(currentURL + '/zonas', function (data, textStatus, jqXHR) {
    $('.sidebar').html(data);
  });
  /**
   * Evento para mostrar el formulario de crear un nuevo modulo
   */

  $(document).on("click", ".newZona", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Nuevo Zona');
    $('#action').removeClass('updateZona');
    $('#action').addClass('saveZona');
    var url = currentURL + '/zonas/create';
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-edificios').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para guardar el nuevo modulo
   */

  $(document).on('click', '.saveZona', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();

    var _token = $("input[name=_token]").val();

    var url = currentURL + '/zonas';
    $.post(url, {
      nombre: nombre,
      descripcion: descripcion,
      _token: _token
    }, function (data, textStatus, xhr) {
      $('.sidebar').html(data);
    }).done(function () {
      $("#modal-body").html('');
      $('.modal-backdrop ').css('display', 'none');
      $('#modal-edificios').modal('hide');
      Swal.fire('Correcto!', 'El registro ha sido guardado.', 'success');
    }).fail(function (data) {
      printErrorMsg(data.responseJSON.errors);
    });
  });
  /**
   * Evento para mostrar el una registro
   */

  $(document).on('click', '.viewZonas', function (event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var url = currentURL + "/zonas/" + id;
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.sidebar').html(result);
      }
    });
    /**
     * Mostrar el breacrumd
     */

    var urlb = currentURL + "/zonas-breadcrumb/" + id;
    $.ajax({
      url: urlb,
      type: 'GET',
      success: function success(result) {
        $('.breadcrumb').html(result);
      }
    });
  });
  /**
   * Evento para mostrar regresar a zonas
   */

  $(document).on('click', '.returnZona', function (event) {
    event.preventDefault();
    var url = currentURL + "/zonas";
    $.ajax({
      url: url,
      type: 'GET',
      success: function success(result) {
        $('.sidebar').html(result);
      }
    });
    $('.breadcrumb').html("");
    $('.viewResult').html("");
  });
  /**
   * Eliminamos las clases agregadas dinamicamente
   */

  $("#modal-edificios").on("hide.bs.modal", function () {
    $('#action').removeClass('updateZona');
    $('#action').removeClass('saveZona');
  });
  /**
   * Evento para mostrar el formulario de edicion
   */

  $(document).on("click", ".editZona", function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar Zona');
    $('#action').removeClass('saveZona');
    $('#action').addClass('updateZona');
    var id = $('.returnUnidad').data('zona-id');
    var url = currentURL + "/zonas/" + id + "/edit";
    $.get(url, function (data, textStatus, jqXHR) {
      $('#modal-edificios').modal('show');
      $("#modal-body").html(data);
    });
  });
  /**
   * Evento para editar el modulo
   */

  $(document).on('click', '.updateZona', function (event) {
    event.preventDefault();
    var nombre = $("#nombre").val();
    var descripcion = $("#descripcion").val();
    var id = $("#zona_id").val();

    var _token = $("input[name=_token]").val();

    var _method = "PUT";
    var url = currentURL + '/zonas/' + id;
    $.ajax({
      url: url,
      type: 'POST',
      data: {
        nombre: nombre,
        descripcion: descripcion,
        _token: _token,
        _method: _method
      },
      success: function success(result) {
        $("#modal-body").html('');
        $('.modal-backdrop ').css('display', 'none');
        $('#modal-edificios').modal('hide');
        $('.breadcrumb').html(result);
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

  $(document).on('click', '.deleteZona', function (event) {
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
        var id = $('.returnUnidad').data('zona-id');

        var _token = $("input[name=_token]").val();

        var _method = "DELETE";
        var url = currentURL + '/zonas/' + id;
        $.ajax({
          url: url,
          type: 'POST',
          data: {
            _token: _token,
            _method: _method
          },
          success: function success(result) {
            $('.breadcrumb').html("");
            $('.sidebar').html(result);
            Swal.fire('Eliminado!', 'El registro ha sido eliminado.', 'success');
          }
        });
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

/***/ 1:
/*!*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/module_edificios/zonas.js ./resources/js/module_edificios/unidades.js ./resources/js/module_edificios/condominios.js ./resources/js/module_edificios/tanques.js ./resources/js/module_edificios/departamentos.js ./resources/js/module_edificios/captura_lectura.js ./resources/js/module_edificios/recibos.js ./resources/js/module_edificios/cargos_adicionales.js ***!
  \*************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/zonas.js */"./resources/js/module_edificios/zonas.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/unidades.js */"./resources/js/module_edificios/unidades.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/condominios.js */"./resources/js/module_edificios/condominios.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/tanques.js */"./resources/js/module_edificios/tanques.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/departamentos.js */"./resources/js/module_edificios/departamentos.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/captura_lectura.js */"./resources/js/module_edificios/captura_lectura.js");
__webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/recibos.js */"./resources/js/module_edificios/recibos.js");
module.exports = __webpack_require__(/*! /Users/miguellugo/Documents/Desarrollos/Personales/admigas/resources/js/module_edificios/cargos_adicionales.js */"./resources/js/module_edificios/cargos_adicionales.js");


/***/ })

/******/ });