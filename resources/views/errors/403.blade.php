
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Favicon -->
        <link rel="icon" href="{{ asset('gentelella/images/logometa.gif') }}" type="image/gif">
        <!-- Normalize -->
        <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
        <!-- Bootstrap -->
        <link href="{{ asset('gentelella/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('gentelella/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <title>Forbidden</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .code {
                border-right: 2px solid;
                font-size: 26px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

            .message {
                font-size: 18px;
                text-align: center;
            }
            a>i{
                height: 100%;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="code">
                403     
            </div>

            <div class="message" style="padding: 10px;">
                Su usuario no tiene permisos para acceder a esta url. contacte al administrador.                           
            </div>
            <a href="{{ url('/home') }}" class="btn btn-sm btn-default" title="Ir al home ">ir al home <i class="fa fa-home"></i></a> 
        </div>
        
         <!-- jQuery -->
         <script src="{{ asset('gentelella/vendors/jquery/jquery.min.js') }}"></script>
         <!-- Moment -->
         <script src="{{ asset('gentelella/vendors/moment/moment.min.js') }}"></script>
         <!-- Bootstrap -->
         <script src="{{ asset('gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>


</body>
</html>
