/*********** NProgress Init ************/
if (typeof NProgress != 'undefined') {
  NProgress.start();
}

/*********** Helpers ************/

window.resetForm = function( $form ){
  $form.find('[type="text"]').val('');
  $form.find('select').val(null).trigger('change');
  $form.find('[type="checkbox"]').prop('checked', false);
}

window.pressEnter = function(e){
  if( event.keyCode == 13 ) {
    e.preventDefault();
    $(':focus').closest('.modal').find('.send-form').trigger('click');
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

function onlyRUTFormated() {
  if( $(this).val() != '' ){
    let rut   = $(this).val().replace(/[^0-9k]/g, ''),
    cuerpo    = formatNumber( $rut.slice(0, -1), 0),
    dv        = $rut.slice(-1).toUpperCase();

    $(this).val( ( $(this).val().length > 7 )  ? cuerpo + '-' + dv : rut );
  }
}

function onlyRUT() {
  if( $(this).val() != '' ){
    let rut   = $(this).val().replace(/[^0-9k]/g, '');
    $(this).val( rut );
  }
}

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
    },
    error: function (xhr, ajaxOptions, thrownError) {
      if( [419].includes( xhr.status ) ){
        location.reload();
      }
    }
  });
}


window.sendForm = function(e){
  e.preventDefault();
  let $form = $(this).closest('form'),
      $formData = new FormData($form[0]);

  $.ajax({
    type: $form.attr('method'), //metodo
    url: $form.attr('action'), //url
    cache       : false,
    contentType : false,
    processData : false,
    data: $formData,
    success: function (data) {
      $form.closest('.modal').modal('hide');
      if ( typeof data.redirect !== 'undefined' ) {
        location.href =  data.redirect;
      }else{
        location.reload();
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {

      if( xhr.status == 422 ){

       $.each(xhr.responseJSON.errors, function( index, elem ){

        let $elem  = index.split('.'),
            $index = ( typeof $elem[1] != 'undefined' ) ? $elem[0] + '_' + $elem[1] : $elem[0];
            $index = ( typeof $elem[2] != 'undefined' ) ? $index + '_' + $elem[2] : $index;

        $form
          .find('#' + $index )
            .addClass('invalid')
          .end()
          .find('#' + $index + '-error')
            .removeAttr('style')
            .html( elem );

        });

        setTimeout( () =>
          $form
            .find(".error")
              .fadeOut(1500)
            .end()
            .find('.invalid')
              .removeClass('invalid'),
        6000);

      }else if( [419].includes( xhr.status ) ){
        location.reload();
      }
    }
  });
}

window.viewInfo = function(e) {
  e.preventDefault();
  let id = $(this).data('item');
  $.ajax({
    type: 'GET',
    url: location.origin + location.pathname + '/' + id,
    data: {
      '_token': $('input[name=_token]').val(),
    },
    success: function ( data ) {

      //Update last ajax response
      lastAjaxResponse.val = { 'action': 'viewInfo', 'data': data };

      $('.viewer.modal')
        .modal('show')
        .find('[data-field]')
        .each( function( i, e ){
          let elem = $(e);

          //Try fill fields
          try {

            //Fill html fields
            if( elem.data('type') === 'raw' ){
              elem.html( '<br/>' + eval( 'data.' + elem.data('field') + " || ' N/D ' " ) );

            //Fill text fields
            }else{
              elem.text( eval( 'data.' + elem.data('field') + " || ' N/D ' " ) );
            }
          }
          catch(error) {
            elem.text( ' N/D ' );
          }
        });
    }
  });
}

window.editItem = function(e) {
  e.preventDefault();
  let id = $(this).data('item'),
      route = $(this).data('route');
  resetForm( $('.modal.edit form') );
  $.ajax({
    type: 'GET', //metoodo
    url: route,
      data: {
          '_token': $('input[name=_token]').val(),
      },
      success: function (data) {

        //Update last ajax response
        lastAjaxResponse.val = { 'action': 'editItem', 'data': data };

        //Open modal and fill fields
        $('.modal.edit')
            .modal('show')
            .find('[data-field]').each( function( i, e ){
              let elem = $(e);
              try{
                options = eval('data.fields.' + elem.data('field') );
              } catch (error) {
                options = '';
                console.log( 'error' + error );
              }

            //Input field
            if( elem.is('input') || elem.is('textarea') ){
              elem.val( options );

            //Select fields
            }else if( elem.is('select') ){

              //Multiple select field
              if( elem.is('[multiple]') && Array.isArray( options ) ){
                let plck = options.reduce( function( res,opt) {
                  res.push(opt.id);
                  return res;
                },[]);
                elem.val( plck ).trigger('change');

              //Simple select field
              }else{
                elem.val( options ).data('default-value', options).trigger('change');

              }

            //Text field
            }else{
              elem.text( options || ' N/D ' );
            }
        }).closest('form').attr('action', data.route );
    },
    error: function (xhr, ajaxOptions, thrownError) {
      if( [419].includes( xhr.status ) ){
        location.reload();
      }
    }
  });
}

window.delItem = function(e) {
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
                Swal.fire({
                  title: 'Borrado!',
                  text: 'Se ha borrado con éxito.',
                  icon: 'success',
                  customClass: {
                    confirmButton: 'confirm-button-class btn custom',
                  }
                })
                location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
              if( [419].includes( xhr.status ) ){
                location.reload();
              }
            }
        });
      }
  });
}

//Blur Modal
//window.polyfilter_scriptpath = 'js/css-filters-polyfill/';
//window.blur_element = '#wrapper';

/*********** Init Assets ************/
$(document).ready(function() {

  /********** Modal Blur *************/
  //$('.modal.blur').on( 'show.bs.modal', (e) => $(window.blur_element).css('polyfilter','blur(4px)') );
  //$('.modal.blur').on( 'hide.bs.modal',  (e) => $(window.blur_element).css('polyfilter','blur(0px)') );

  /********** Cruds Events *************/
  $('.mark_as_read').on('click', markAsRead );

  $('.send-form').on('click', sendForm );
  $('button.link').on('click', goTo );

  /**** Actions Table ******/
  $('.table').on('click', '.actions .btn_view', window.viewInfo );
  $('.table').on('click', '.actions .btn_edit', window.editItem );
  $('.table').on('click', '.actions .btn_del',  window.delItem );

  /**** Formats Inputs ******/
  $('input.numeric').on('keypress', onlyNumbers );
  $('input.alpha').on('keypress',   onlyAlphanumeric );
  $('input.letters').on('keypress', onlyLetters );
  $('input.rut').on('keypress', onlyRUT );
  $('input.rut-format').on('keypress', onlyRUTFormated );
  //$('input.dates').on('keypress', onlyDates );

  $(window).on('keydown', pressEnter);

  input_optional();
  Inputmask().mask(document.querySelectorAll("input"));

  new ClipboardJS('.btn-copy');

  $('.select:not([multiple])').select2({
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
