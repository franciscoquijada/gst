
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
var $ = require("jquery");

require('./bootstrap');


window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const app = new Vue({ el: '#app' });
const Swal 		= require('sweetalert2')
const NProgress = require('NProgress');
const select2 	= require('select2');
const Inputmask = require('inputmask');

/*********** Helpers ************/

window.soloLetras = function(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "áéíóúabcdefghijklmnñopqrstuvwxyz ";
  especiales = "8-37-39-46";

  tecla_especial = false
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true; 
      break;
    }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial){
    return false;
  }
}

window.soloNum = function(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789 ";
  especiales = "8-37-39-46";

  tecla_especial = false
  for(var i in especiales){
      if(key == especiales[i]){
          tecla_especial = true;
          break;
      }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial){
      return false;
  }
}

window.resetForm = function( $form ){
  $form.find('[type="text"]').val('');
  $form.find('select').val(null).trigger('change');
  $form.find('[type="checkbox"]').prop('checked', false);
}

window.pressEnter = function(e){
  if( event.keyCode == 13 ) {
    e.preventDefault();
    $(':focus').parents('.modal').find('.send-form').trigger('click');
    return false;
  }
}

window.fillList = function( list, data, empty = null ){
  list.html('');
  if( data.length ){
    data.forEach( function(e,i){
      list.prepend('<li>' + e.name + '</li>');
    });
  }else{
    list.prepend('<li>' + ( empty || 'No hay elementos registrados' ) + '</li>');
  }
}

window.lastAjaxResponse = {
	aInternal: 10,
	aListener: function(val) {},
	set val(val) {
		this.aInternal = val;
		this.aListener(val);
	},
	get val() {
		return this.aInternal;
	},
	registerListener: function(listener) {
		this.aListener = listener;
	}
};

console.log('init_helpers');


/********** Cruds Events *************/

$('.send-form').on('click', sendForm );
$('.btn_view').on('click', viewInfo );
$('.btn_edit').on('click', editItem );
$('.btn_del').on('click', delItem );
$(window).on('keydown', pressEnter);

/*********** Cruds Functions ************/

function sendForm( e ){
	e.preventDefault();
	let $form = $(this).parents('form');

	$.ajax({
		type: $form.attr('method'), //metodo
		url: $form.attr('action'), //url
		data: $form.serialize(),
		success: function (data) {

			if (data.status === 500) {

				$.each(data.errors, function( index, elem ){

					let $index = index.split('.')[0];
					$form.find('#' + $index ).addClass('invalid');
					$form.find('#' + $index + '-error')
						.removeAttr('style')
                    	.html( elem );
                });
                setTimeout(function () {
                	$form.find(".error").fadeOut(1500);
                	$form.find('.invalid').removeClass('invalid')
                }, 6000);
            } else {
            	$form.find('.modal').modal('hide');
            	location.reload();
            }
        }
    });
}

function viewInfo(e) {
	e.preventDefault();
	let id = $(this).data('item');
	$.ajax({
		type: 'GET', //metoodo
		url: window.location + '/' + id, //id del delete
		data: {
		  '_token': $('input[name=_token]').val(),
		},
		success: function ( data ) {
			lastAjaxResponse.val = { 'action': 'viewInfo', 'data': data };
			$('.viewer.modal')
				.modal('show')
				.find('[data-field]')
				.each( function( i, e ){
					let elem = $(e);

					try {
						elem.text( eval( 'data.' + elem.data('field') + " || ' N/D ' " ) );
					}
					catch(error) {
						//console.error(error);
						elem.text( ' N/D ' );
					}
				});
		}
	});
}

function editItem(e) {
	e.preventDefault();
	let id = $(this).data('item');
	resetForm( $('.modal.edit form') );
	$.ajax({
		type: 'GET', //metoodo
		url: window.location + '/' + id + '/edit',
	    data: {
	        '_token': $('input[name=_token]').val(),
	    },
	    success: function (data) {

	    	lastAjaxResponse.val = { 'action': 'editItem', 'data': data };
	    	$('.modal.edit')
		        .modal('show')
		        .find('[data-field]').each( function( i, e ){
		        	let elem = $(e),
		        	options = eval('data.fields.' + elem.data('field') ) || '';

		        if( elem.is('input') || elem.is('textarea') ){ //Input
		        	elem.val( options );
		        }else if( elem.is('select') ){ //Select
		        	if(elem.is('[multiple]') && Array.isArray( options ) ){ //Multiple
		        		let plck = options.reduce( function( res,opt) {
		        			res.push(opt.id);
		        			return res;
		        		},[]);
		        	elem.val( plck ).trigger('change');
		        	}else{ //Simple
		        		elem.val( options ).trigger('change');
		        	}
		        }else{ //Text

		        	elem.text( options || ' N/D ' );
		        }
		    }).parents('form').attr('action', data.route );
		}
	});
}

function delItem(e) {
	e.preventDefault();
	let route = $(this).data('route');
	Swal.fire({
		title: '¿Estas seguro?',
		text: "Esta operación no puede revertirse!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'No, cancelar! <i class="fas fa-times"></i>',
	 	confirmButtonText: 'Si, Borrar! <i class="fas fa-check"></i>',
		customClass: {
			confirmButton: 'confirm-button-class btn',
			cancelButton: 'cancel-button-class btn',
		},
	}).then((result) => {
    
	    if (result.value) {
	    	$.ajax({
		      	type: 'DELETE', //metodo
		      	url: route, //id del delete
		      	data: {
		      		'_token': $('input[name=_token]').val(),
		      	},
		      	success: function (data) {

		      		if (data.status != 500) {
		      			Swal.fire(
		      				'Deleted!',
		      				'Your file has been deleted.',
		      				'success'
		      			)
		      			location.reload();
		      		}
		      	}
		    });
	    }
	});
}

console.log('init_crud_functions');


/*********** Init Assets ************/

$( window ).on( "load", function() {
	if (typeof NProgress != 'undefined') {
		NProgress.start();
	}
});

$(document).ready(function() {
    
    /*$('.datepicker').datetimepicker({
            format: 'DD/MM/YYYY',
        });*/

    $('.table.table-striped').DataTable({
        "language": {
            url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json'
        }
    });

    let newOption = new Option( '- Seleccione -', '', true, true);
    
        $('.select:not([multiple])').prepend(newOption).select2({
            width: '100%',
            language: "es"
        });

    $.fn.select2.amd.require(
      [ 'select2/utils', 'select2/dropdown', 'select2/dropdown/attachBody'], 
      function (Utils, Dropdown, AttachBody) {
        function SelectAll() { }

        SelectAll.prototype.render = function (decorated) {
          var $rendered = decorated.call(this),
              self = this,
              $selectAll = $('<a/>').addClass('btn w-100').text('Seleccionar todos');

          $rendered.find('.select2-dropdown').prepend( $selectAll );

          $selectAll.on('click', function (e) {
            var $results = $rendered.find('.select2-results__option[aria-selected=false]');
            $results.each( function () {
              var $result = $(this),
                  data = $result.data('data');
              
              self.trigger('select', {
                data: data
              });
            });

          self.trigger('close');
          });

          return $rendered;
        };

      $(".select[multiple]").select2({
        placeholder: "Selecionar...",
        width: '100%',
        language: "es",
        dropdownAdapter: Utils.Decorate(
          Utils.Decorate( Dropdown, AttachBody ),
        SelectAll ),
      });
    });

    if (typeof NProgress != 'undefined') {
      NProgress.done();

    	$(document).ajaxStart( () => NProgress.start() );
    	$(document).ajaxStop( () => NProgress.done() );
    }

});

console.log('init_assets');