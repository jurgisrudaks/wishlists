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

    <!-- Custom Google Web Font -->
    {{ HTML::style('font-awesome/css/font-awesome.min.css') }}
    {{ HTML::style('http://fonts.googleapis.com/css?family=Source+Sans+Pro:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic') }}

    <!-- Add custom CSS here -->
    {{ HTML::style('css/master.css') }}
    {{ HTML::style('css/profile.css') }}
    {{ HTML::style('css/wishlists.css') }}
    {{ HTML::style('css/socialButtons.css') }}
    {{ HTML::style('css/basicDropzone.css') }}
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

            <div class="collapse navbar-collapse navbar-right navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    @if (!$loggedIn)
                        <li><a href="/signin">Pieslēgties</a>
                        </li>
                        <li><a href="/register">Reģistrēties</a>
                        </li>
                    @else
                        <li><a href="/{{ $user->slug }}">Mani saraksti</a>
                        </li>  
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">{{ $user->first_name }} {{ $user->last_name }} <b class="caret"></b></a>
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
    @if($profile->cover_image)
        <div class="container-fluid cover" style="background-image: url({{ Image::resize($profile->cover_image, 1900, 840, true) }});">
    @else
        <div class="container-fluid cover" style="background-image: url('../img/default_cover.jpg');">
    @endif
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if($profile->photo)
                        <img class="pic img-circle" src="{{ Image::resize($profile->photo, 120, 120, true) }}" alt="...">
                    @else
                        <img class="pic img-circle" src="http://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/twDq00QDud4/s120-c/photo.jpg" alt="...">
                        }
                    @endif
                    <div class="name">
                    @if ($loggedIn && ($user->slug == $profile->slug))
                        <h1>{{ $user->first_name . ' ' . $user->last_name }}
                        <span class="share">
                            <a href="javascript:void(0);" class="trigger"><span id="shareBtn" title="Kopīgot" class="glyphicon glyphicon-link"></span></a>
                            <div class="head hide">
                                Dalies ar profila saiti
                                <a href="javascript:void(0);" class="pull-right" onclick="$('.share > .trigger').popover(&quot;hide&quot;);">&times;</a>
                            </div>
                            <div class="content hide">
                                <a href="javascript:void(0);" data-toggle=""></a>
                                <center>
                                    Tava publiskā profila saite:
                                    <div class="input-group">
                                        <span class="input-group-addon"><a id="changeUrlBtn" data-toggle="modal" data-target="#changeUrlModal" href="/changeUrl" title="Mainīt profila saiti"><span class="glyphicon glyphicon-edit"></span></a></span>
                                        <input id="profileURL" onClick="this.select();" class="form-control" type="text" style="cursor: pointer;" value="http://esvelos.lv/{{ $profile->slug }}" readonly>
                                    </div>
                                    <br/>
                                    <a href="javascript:void(0);" onclick="tweet('http://esvelos.lv/{{ $profile->slug }}','Apskati manus vēlmju sarakstus')" class="btn btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                                    <a href="javascript:void(0);" onclick="postToFb('http://esvelos.lv/{{ $profile->slug }}')" class="btn btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                                    <a href="javascript:void(0);" onclick="shareOnGp('http://esvelos.lv/{{ $profile->slug }}')" class="btn btn-social-icon btn-google-plus"><i class="fa fa-google-plus"></i></a>
                                </center>
                            </div>
                        </span>
                        </h1>
                    @else
                        <h1>{{ $profile->first_name . ' ' . $profile->last_name }}</h1>
                    @endif
                    </div>
                    @if ($loggedIn && ($user->slug == $profile->slug))
                        <a id="changeCoverBtn" class="btn btn-xs btn-primary change" style="margin:10px;" data-toggle="modal" data-target="#changeCoverModal" href="/changeCover" title="Mainīt vāka attēlu"><span class="glyphicon glyphicon-picture"></span> Mainīt vāka attēlu</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- Change Cover Modal -->
    <div class="modal fade" id="changeCoverModal" tabindex="-1" role="dialog" aria-labelledby="changeCoverModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Change Profile URL Modal -->
    <div class="modal fade" id="changeUrlModal" tabindex="-1" role="dialog" aria-labelledby="changeUrlModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>

    <!-- Change Cover Modal -->
    <div class="modal modal-static fade" id="processingImage" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <img src="/img/loading.gif" class="icon" />
                        <h4>Sagatavoju...</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{ HTML::script('js/jquery-1.11.0.min.js') }}
    {{ HTML::script('js/bootstrap.min.js') }}
    {{ HTML::script('js/init.js') }}
    {{ HTML::script('js/validator.js') }}
    {{ HTML::script('js/dropzone.js') }}

    @yield('scripts')

</div>
</body>

</html>