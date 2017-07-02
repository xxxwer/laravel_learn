<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Infinite Link">
        <meta name="keywords" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>
            Infinite Link
        </title>


        <link href="/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="/js/jquery-3.1.1.min.js"></script>
        <script src="/plugins/bootstrap/js/bootstrap.min.js"></script>
    </head>

<style media="screen">
    body { padding-top: 70px; }
</style>

    <body>
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar_001">
        <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Link.</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

        <ul class="nav navbar-nav">
            <li><a href="/index">Frequent List</a></li>

            <form class="navbar-form navbar-left" role="search" action="/search/keyword" method="post">
                {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" placeholder="keyword mysql search" name="search_word">
            </div>
            <button type="submit" class="btn btn-default">mysql</button>
            </form>

            <form class="navbar-form navbar-left" role="search" action="/fulltextSearch/keyword" method="post">
                {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" placeholder="sphinx full text search" name="search_word">
            </div>
            <button type="submit" class="btn btn-default">sphinx</button>
            </form>

            <form class="navbar-form navbar-left" role="search" action="/esFulltextSearch/keyword" method="post">
                {{ csrf_field() }}
            <div class="form-group">
                <input type="text" class="form-control" placeholder="ES full text search" name="search_word">
            </div>
            <button type="submit" class="btn btn-default">ES</button>
            </form>
        </ul>



        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Other Menu<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="/addKeyword">Add Root Keyword</a></li>
                    <li><a href="/rootKeyword">root keyword list</a></li>
                    <li><a href="/otherFunction">other function</a></li>
                    <!-- <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li> -->
                    <li class="divider"></li>
                    <li><a href="{{ route('Admin::logout') }}">logout</a></li>
                </ul>
            </li>
        </ul>
        </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
        </nav>

          @yield('content')

<script type="text/javascript">

setTopBarBtn();

function setTopBarBtn(){
    var url = window.location.href;
    url = url.split('/');
    var str = '/' + url[3];
    var a_obj = $('#navbar_001').find('a[href="'+ str +'"]');

    var li_obj = a_obj.parent();
    var dropdown_obj = li_obj.parent().parent();

    if (dropdown_obj.attr('class') == 'dropdown' ) {
        dropdown_obj.attr('class', 'dropdown active');
    }

    li_obj.attr('class', 'active');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

}
</script>

    </body>
</html>
