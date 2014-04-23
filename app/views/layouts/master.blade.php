<!DOCTYPE html>
<html lang="lv">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Vēlmju sarakstu izveides serviss</title>

    <!-- Bootstrap core CSS -->
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('css/jasny-bootstrap.min.css') }}

    <!-- Custom Google Web Font -->
    {{ HTML::style('font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic') }}

    <!-- Add custom CSS here -->
    {{ HTML::style('css/master.css') }}
    @yield('stylesheets')

</head>

<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Navigācija</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://esvelos.lv">es.vēlos</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    @if (!Sentry::check())
                        <li><a href="/signin">Pieslēgties</a>
                        </li>
                        <li><a href="/register">Reģistrēties</a>
                        </li>
                    @else
                        <li><a href="/{{ $user->slug }}">Mani saraksti</a>
                        </li>
                        
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $user->first_name }} {{ $user->last_name }} <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="/settings">Uzstādījumi</a></li>
                                <li class="divider"></li>
                                <li><a href="/signin/logout">Iziet</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    @yield('content')
    
    <!-- JavaScript -->
    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/jasny-bootstrap.min.js') }}
    {{ HTML::script('js/validator.js') }}
    <script type="text/javascript">
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
    </script>
    @yield('scripts')
</div>
</body>

</html>
