@props(['type', 'size', 'route', 'id', 'method'])

<!-- Modal {{ $id ?? 'create' }} -->
<div class="modal fade {{ $type ?? 'create' }}" tabindex="-1" role="dialog" aria-hidden="true" id="{{ $id ?? 'create' }}">
  <div class="modal-dialog modal-{{ $size ?? 'md' }} modal-dialog-centered animated">
    <div class="modal-content">
      @isset( $route )
        {!! Form::open([ 'id' => ( $id ?? 'create' ) . '_form', 'route' => $route, 'method' => $method ?? 'POST' ]) !!}
      @else
        {!! Form::open([ 'id' => ( $id ?? 'create' ) . '_form', 'method' => $method ?? 'POST' ]) !!}
      @endisset
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
        <div class="modal-footer">
          <div class="text-right">
          	<x-button.link class="btn-success send-form" label="Guardar" icon="far fa-save" />
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>  
</div>
<!-- / Modal {{ $id ?? 'create' }} -->