@if (session('Notify.alert'))
<script type="text/javascript">
	$( {!! json_encode( session('Notify.alert') ) !!}  ).each( function(i,e){

		var speed = 3000;

		setTimeout( function () {
			Swal.mixin({
				toast: true,
			position: 'top-end',
			showConfirmButton: false,
			timer: speed,
			timerProgressBar: true,
			onOpen: (toast) => {
				toast.addEventListener('mouseenter', Swal.stopTimer)
				toast.addEventListener('mouseleave', Swal.resumeTimer)
			}
		}).fire(JSON.parse(e));
		}, i * speed);
	});
</script>
@endif
{{ session()->forget('Notify.alert') }}