<div class="modal fade create" tabindex="-1" role="dialog" aria-hidden="true" id="reset_password">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      {!! Form::open(['id' => 'form_create', 'route' => 'password.email','method'=>'POST']) !!}
        @csrf
        <div class="modal-header text-center bg-primary">
          <h4 class="modal-title">{{ __('Restablecer contraseña') }}</h4>
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">×</span>          
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
              <label class="form-group">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="form-control" id="email" autocomplete="off" placeholder="Correo Electrónico">
              <span id="email-error" style="display: none;" class="label label-danger ml-1 error"></span>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
          <div class="col-12 text-center">
            <a class="btn btn-success send-form">
              {{ __('Enviar') }} <i class="fas fa-envelope"></i></i>
            </a>
          </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>  
</div>