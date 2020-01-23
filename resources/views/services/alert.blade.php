@if (session('PNotify.alert'))
  <script type="text/javascript">
    @foreach ( session('PNotify.alert') as $alert )
      PNotify.alert( {!! $alert !!} );
    @endforeach
  </script>
@endif
{{ session()->forget('PNotify.alert') }}