@extends('layout/admin_layout')
@section('content')

<div class="row" style="padding:10px;">
    <div class="col-sm-8 col-sm-offset-2">
        <form role="form" action="/doAddKeyword" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="exampleInputEmail1">Key Word</label>
                <input type="text" class="form-control" name="keyword">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Content</label>
                <textarea class="form-control" rows="6" name="content"></textarea>
            </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>

@stop
