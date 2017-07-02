<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>无限</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="beitang_road_app">

    <link rel="stylesheet" href="{{ assets('/plugins/bootstrap/css/bootstrap.min.css') }}">
        <!--[if lt IE 9]>
          <script src="{{ assets('/assets/vendors/html5shiv-3.7.3/html5shiv.min.js') }}"></script>
          <script src="{{ assets('/assets/vendors/respond.js-1.4.2/respond.min.js') }}"></script>
        <![endif]-->
    <script src="{{ assets('/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ assets('/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body>
    <div class="container" id="login-form">
        <div class="row" style="text-align:center;margin-top: 120px;margin-bottom: 50px;">
            <div href="#" class="login-logo">
              <h2></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-xs-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>无限</h5>
                    </div>

                    <div class="panel-body">

                        <form action="{{ route('Admin::doLogin') }}" method="post" class="form-horizontal" id="validate_form">
                            {{ csrf_field() }}
                            <div class="form-group mb-md">
                            <div class="col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                      <span class="ti ti-user"></span>
                                  </span>
                                  <input type="text" name="email" class="form-control" placeholder="Email">
                              </div>
                            </div>
                            </div>

                            <div class="form-group mb-md">
                            <div class="col-xs-12">
                              <div class="input-group">
                                  <span class="input-group-addon">
                                      <span class="ti ti-key"></span>
                                  </span>
                                  <input type="password" name="password" class="form-control" placeholder="Password">
                              </div>
                            </div>
                            </div>

                            <div class="form-group mb-n">
                                <div class="col-xs-12">
                                    <!-- <a href="#" class="pull-left">Forgot password?</a> -->
                                    <div class="checkbox-inline icheck p-n">
                                        <label>
                                            <input type="checkbox" name="rememberMe" value="1">
                                            自动登录
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" id="validate_form_submit" style="display:none;">
                        </form>
                    </div>

                    <div class="panel-footer">
                        <div class="clearfix">
                        <button type="button" id='login_button' class="btn btn-primary pull-left">Login</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
    <script type="text/javascript">
      $('#login_button').on('click',function(){
        $('#validate_form_submit').click();
      });

      var alertInfo = "{{ $alertInfo }}";
      if (alertInfo != "") {
          alert(alertInfo);
      }
    </script>

</body>

</html>
