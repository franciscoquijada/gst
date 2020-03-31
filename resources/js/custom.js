/*********** Helpers ************/

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
$('.mark_as_read').on('click', markAsRead );

$('.send-form').on('click', sendForm );
$('button.link').on('click', goTo );

/**** Actions Table ******/
$('.table').on('click', '.actions .btn_view', viewInfo );
$('.table').on('click', '.actions .btn_edit', editItem );
$('.table').on('click', '.actions .btn_del',  delItem );

/**** Formats Inputs ******/
$('input.numeric').on('keypress', onlyNumbers );
$('input.alpha').on('keypress',   onlyAlphanumeric );
$('input.letters').on('keypress', onlyLetters );

$(window).on('keydown', pressEnter);

/*********** Event Functions ************/

function input_optional(){
  $('.optional').each(function( i, e ){
    let $this = $(this);
    $this.hide();

    $( '[name="' + $this.data('parent') + '"]' ).on('change', function(e){
      ( $(this).val() == $this.data('answer') ) ? $this.show() : $this.hide();
    });
  });
}

function onlyLetters() {
  $(this).val($(this).val().replace(/[^A-Za-zñÑ ]/g, ''));
}

function onlyAlphanumeric() {
  $(this).val($(this).val().replace(/[^0-9A-Za-zñÑ ]/g, ''));
}

function onlyNumbers() {
  $(this).val( $(this).val().replace(/[^0-9]/g, '') );
}

/* Pendiente 
function onlyRUT() {
  $(this).val($(this).val().replace(/[^0-9k-]/g, ''));
}

function onlyDates() {
    var date = $(this).val().replace(/[^0-9]/g, ''),
        d = date.substring(0,2),
        m = date.substring(2,4) != '' ? '/' + date.substring(2,4) : '',
        y = date.substring(4,8) != '' ? '/' + date.substring(4,8) : '';
  $(this).val( d + m + y );
}*/

function goTo( e ){
  e.preventDefault();
  if( $(this).data('route').length > 0 ){
    location.href =  $(this).data('route');
  } 
}

function markAsRead(e) {
  e.preventDefault();
  let $this = $(this);
  $.ajax({
    type: 'GET',
    url: $(this).data('route'),
    data: {
      '_token': $('input[name=_token]').val(),
    },
    success: function (data) {
      if ( data == 'success' ) {
        $this.find('.badge-counter').text(0);
      }
    }
  });
}


function sendForm( e ){
  e.preventDefault();
  let $form = $(this).parents('form');

  $.ajax({
    type: $form.attr('method'), //metodo
    url: $form.attr('action'), //url
    data: $form.serialize(),
    success: function (data) {
      $form.find('.modal').modal('hide');
      if ( typeof data.redirect !== 'undefined' ) {
        location.href =  data.redirect;
      }else{
        location.reload();
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {

      if( xhr.status == 422 ){

       $.each(xhr.responseJSON.errors, function( index, elem ){

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
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    cancelButtonText: 'No, cancelar! <i class="fas fa-times"></i>',
    confirmButtonText: 'Si, Borrar! <i class="fas fa-check"></i>',
    customClass: {
      confirmButton: 'confirm-button-class btn custom',
      cancelButton: 'cancel-button-class btn custom',
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
                Swal.fire(
                  'Borrado!',
                  'Se ha borrado con éxito.',
                  'success'
                )
                location.reload();
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

  input_optional();
  Inputmask().mask(document.querySelectorAll("input"));

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