@if (session('Notify.alert'))
<script type="text/javascript">
	console.log( @json( session('Notify.alert') ) );
	$( @json( session('Notify.alert') ) ).each( function(i,e){

		var speed = 5000;

		console.log('hola');

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
{{ session()->forget('Notify.alert') }}
@endif