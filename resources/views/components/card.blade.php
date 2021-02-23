@push('modals')
<!-- Card -->
<div class="modal fade @if( $edit ?? false ) edit @else create @endif" tabindex="-1" role="dialog" aria-hidden="true" id="{{ $id }}">
  <div class="modal-dialog modal-md modal-dialog-centered bounceIn animated">
    <div class="modal-content">
      {!! Form::open([ 'id' => ( $id ?? 'create' ) . '_form', 'route' => $route, 'method' => $method ?? 'POST' ]) !!}
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
          	{{ $footer ?? '' }}
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>  
</div>
<!-- / Card -->
@endpush