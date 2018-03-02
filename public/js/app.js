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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

jq3 = jQuery.noConflict();
jq3(function ($) {

  //
  $.validator.addMethod('date', function (value, element) {
    return this.optional(element) || moment(value, 'DD/MM/YYYY').isValid();
  }, 'Por favor, forneça uma data no formato dd/mm/aaaa.');

  // masks
  $('.date').mask('00/00/0000');
  $('.date').datepicker({
    language: 'pt-BR'
  });

  //
  moment.locale('pt-br');

  // validation
  $('form').each(function (i, o) {
    $(o).validate({
      errorElement: 'em',
      errorPlacement: function errorPlacement(error, element) {
        error.addClass("help-block");
        if (element.prop('type') === 'checkbox') {
          error.insertAfter(element.parent('label'));
        } else {
          error.insertAfter(element);
        }
      },
      highlight: function highlight(element, errorClass, validClass) {
        $(element).parents('.form-group').addClass('has-error').removeClass('has-success');
      },
      unhighlight: function unhighlight(element, errorClass, validClass) {
        $(element).parents('.form-group').addClass('has-success').removeClass('has-error');
      }
    });
  });

  // filter transactions
  var filter = $('#filter');
  filter.find('#days').on('change', function (event) {
    var days = $(this).val();
    var start = moment().subtract(days, 'days').format('DD/MM/YYYY');
    var end = moment().format('DD/MM/YYYY');
    filter.find('#start').val(start);
    filter.find('#end').val(end);
  }).trigger('change');

  // form token
  var formToken = $('#form-token');
  formToken.on('submit', function (event) {
    event.preventDefault();
    var $this = $(this);
    var data = {
      _token: $this.find('[name="_token"]').val(),
      _method: $this.find('[name="_method"]').val()
    };

    formToken.find('button[type="submit"]').prop('disabled', true);

    $.post($this.attr('action'), data, function (response) {

      var _warning = formToken.find('.alert.alert-warning');
      _warning.addClass('hide');
      var _default = formToken.find('.alert.alert-default');
      _default.removeClass('hide');
      var message1 = _default.find('#message1');
      message1.html('<b class="text-success">Token gerado com sucesso.</b>');
      var message2 = _default.find('#message2');
      if (message2.length == 0) {
        message2 = $('<div id="message2">');
        message2.insertAfter(message1);
      }
      message2.text('Anote o número: ' + response.token);
    }).fail(function (response) {

      var _warning = formToken.find('.alert.alert-warning');
      _warning.addClass('hide');
      var _default = formToken.find('.alert.alert-default');
      _default.removeClass('hide');
      _default.find('#message1').html('<b class="text-danger">Ocorreu um erro ao tentar gerar o token.</b>');
      _default.find('#message2').remove();
    }).always(function () {

      formToken.find('button[type="submit"]').prop('disabled', false);
    });
  });

  // send token
  var sendToken = $('#form-token a');
  sendToken.on('click', function (event) {
    event.preventDefault();
    var $this = $(this).closest('form');
    var data = {
      _token: $this.find('[name="_token"]').val()
    };

    formToken.find('button[type="submit"]').prop('disabled', true);

    $.post($this.attr('action') + '/send', data, function (response) {

      var _warning = formToken.find('.alert.alert-warning');
      _warning.addClass('hide');
      var _default = formToken.find('.alert.alert-default');
      _default.removeClass('hide');
      var message1 = _default.find('#message1');
      message1.html('<b class="text-success">Token enviado com sucesso.</b>');
      var message2 = _default.find('#message2');
      var message3 = _default.find('#message3');
      if (message2.length == 0) {
        message2 = $('<div id="message2">');
        message2.insertAfter(message1);
      }
      message2.text('Token enviado para ' + response.email);
      message3.addClass('text-muted').text('[Enviar por e-mail]');
    }).fail(function (response) {

      var _warning = formToken.find('.alert.alert-warning');
      _warning.addClass('hide');
      var _default = formToken.find('.alert.alert-default');
      _default.removeClass('hide');
      _default.find('#message1').html('<b class="text-danger">Ocorreu um erro ao tentar gerar o token.</b>');
      _default.find('#message2').remove();
    }).always(function () {

      formToken.find('button[type="submit"]').prop('disabled', false);
    });
  });

  //
  var toggleItems = $('.toggle-items');
  toggleItems.on('click', function (event) {
    var items = $('.checkout .items');
    if (items.hasClass('hidden-sm')) {
      items.removeClass('hidden-sm hidden-xs');
      toggleItems.find('.text').text('Ocultar resumo da compra');
    } else {
      items.addClass('hidden-sm hidden-xs');
      toggleItems.find('.text').text('Exibir resumo da compra');
    }
  });

  // form float
  var formFloat = $('.form-float');
  formFloat.find('.form-control').each(function (i, o) {
    var formControl = $(this);
    var formGroup = formControl.closest('.form-group');
    formControl.on('focus', function () {
      formGroup.addClass('focus');
    });
    formControl.on('blur', function () {
      formGroup.removeClass('focus');
      if (formControl.val() == '') {
        formGroup.removeClass('filled');
      }
    });
    formControl.on('keyup change', function () {
      formGroup.addClass('filled');
    }).trigger('change').trigger('blur');
  });
});

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);