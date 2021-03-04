@props(['type', 'size', 'route', 'id', 'method'])

<!-- Modal {{ $id ?? 'create' }} -->
<div class="modal fade {{ $type ?? 'create' }} {{ $class ?? '' }}" tabindex="-1" role="dialog" aria-hidden="true" id="{{ $id ?? 'create' }}">
  <div class="modal-dialog modal-{{ $size ?? 'md' }} modal-dialog-centered animated">
    <div class="modal-content">

      @if( ( $type ?? 'create' ) != 'viewer' )
      
        @php
            $form_props = ( isset( $route ) ) ?
            [ 
              'id'     => ( $id ?? 'create' ) . '_form', 
              'route'  => $route, 
              'method' => $method ?? 'POST'
            ]:[ 
              'id'      => ( $id ?? 'create' ) . '_form', 
              'method'  => $method ?? 'POST' 
            ];
        @endphp

        {!! Form::open( $form_props ) !!}

      @endif
      <div class="modal-header text-center bg-primary">
        <h4 class="modal-title">{{ $title ?? '' }}</h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">×</span>          
        </button>
      </div>
      <div class="modal-body">
        {{ $slot ?? '' }}
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer text-right">
        @isset( $footer )
        {{ $footer ?? '' }}
        @else
        <x-button.link class="btn-success send-form" label="Guardar" icon="far fa-save" />
        @endisset
      </div>
        
      @if( ( $type ?? 'create' ) != 'viewer' )
        {!! Form::close() !!}
      @endif
      
    </div>
  </div>  
</div>
<!-- / Modal {{ $id ?? 'create' }} -->