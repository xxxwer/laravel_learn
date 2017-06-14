@extends('layout/admin_layout')
@section('content')

<div class="row" style="padding:10px;">
    <div class="col-sm-12">
        <div class="panel panel-success">
          <div class="panel-heading">other function</div>
          <div class="panel-body">
            <div class="col-xs-12">
              <pre>{{ $result }}</pre>
            </div>
            <a href="/ESindexALL" class="btn btn-default">ES index all content</a>
            <a href="/ESseeHealth" class="btn btn-default">ES Health</a>
            <a href="/ESIndexStatus" class="btn btn-default">ES All Index status</a>
            <hr>
            <form action="/ESQueryJson" method="post">
                {{ csrf_field() }}
              <div class="form-group">
                <textarea name="query_json" rows="8" cols="80">{{ isset($query_json) ? $query_json : '' }}</textarea>
              </div>
              <button type="submit" class="btn btn-default">ES json query</button>
            </form>
            <hr>
            <form action="/garbageInfoFilter" method="post">
                {{ csrf_field() }}
              <div class="form-group">
                <textarea name="info_string" rows="8" cols="80">{{ isset($info_string) ? $info_string : '' }}</textarea>
              </div>
              <button type="submit" class="btn btn-default">is garbage</button>
            </form>
            <form action="/trainGarbageInfoFilter" method="post">
                  {{ csrf_field() }}
                <select class="form-control" name="info_type">
                  <option value="garbage_count">garbage</option>
                  <option value="useful_count">useful</option>
                </select>
                <div class="form-group">
                  <textarea name="info_string" rows="8" cols="80">{{ isset($info_string) ? $info_string : '' }}</textarea>
                </div>
                <button type="submit" class="btn btn-default">train</button>
            </form>
            <form action="/clearGarbageInfoFilterDB" method="post">
                  {{ csrf_field() }}
                <div class="form-group">
                  <input name="pass" class="form-control">{{ isset($info_string) ? $info_string : '' }}</input>
                </div>
                <button type="submit" class="btn btn-default">clear DB</button>
            </form>
          </div>
           <div class="panel-footer"></div>
        </div>
    </div>
</div>

@stop
