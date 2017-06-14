@extends('layout/admin_layout')
@section('content')

<style media="screen">
    .input_color{
        background-color: lightgoldenrodyellow;
    }
    .link_keyword_list_title{
        cursor: pointer;
    }
    .panel-body{
        overflow: auto;
    }
</style>

<div class="row" style="padding:10px;">
    <div class="col-md-3">

        <div class="panel panel-default" id='link_keyword_list_box'>
            <div class="panel-heading link_keyword_list_title">Parent KeyWord</div>
            <div class="panel-body">
                <button type="button" class="btn btn-primary" id="add_parent_keyword_btn">Add Parent KeyWord</button>
                <hr>
                <?php
                foreach ($info['parent_keyword'] as $key1 => $value1) {    
                    echo '<a href="/detail?id_keyword='.$key1.'" class="btn btn-info btn-xs">'.$value1->keyword.'</a>&nbsp;&nbsp;<a  href="/deleteKeywordLink?id_keyword_parent='.$value1->id.'&id_keyword='.$info['keyword']->id.'" class="label label-danger">delete link</a><br>';
                }
                ?>

            </div>
        </div>

        
        <div class="panel panel-default">
            <div class="panel-heading link_keyword_list_title">Same Level KeyWord</div>
            <div class="panel-body">
                <?php
                foreach ($info['same_level_keyword'] as $parent_keyword_name => $child_keyword) {
                    echo '<a class="btn btn-default btn-sm" href="javascript:;">' . $parent_keyword_name .'</a><br>';
                    foreach ($child_keyword as $key1 => $value1) {
                        if ($key1 == $info['keyword']->id) {
                            echo '<a href="/detail?id_keyword='.$key1.'" class="btn btn-success btn-xs">'.$value1->keyword.'</a><br>';
                        } else {
                            echo '<a href="/detail?id_keyword='.$key1.'" class="btn btn-info btn-xs">'.$value1->keyword.'</a><br>';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading link_keyword_list_title">Child KeyWord</div>
            <div class="panel-body">
                <button type="button" class="btn btn-primary" id="add_keyword_btn">Add Child KeyWord</button>
                <hr>
                <?php
                foreach ($info['child_keyword'] as $key1 => $value1) {
                    echo '<a href="/detail?id_keyword='.$key1.'" class="btn btn-info btn-xs">'.$value1->keyword.'</a><br>';
                }
                ?>
            </div>
        </div>

    </div>


    <div class="col-md-9">
        <form role="form" action="/updateKeyword" method="post">
            {!!csrf_field()!!}
            <input type="hidden" name="id_keyword_link_content_info" value="<?php echo empty($info['keyword_link_content_info']) ? '' : $info['keyword_link_content_info']->id_keyword; ?>">
          <div class="form-group">
            <label for="exampleInputEmail1">Key Word</label>
            <input type="text" class="form-control input_color" name="keyword" value="<?php echo $info['keyword']->keyword; ?>">
                <input type="hidden" name="id_keyword" value="<?php echo $info['keyword']->id; ?>">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Content</label>
            <textarea class="form-control input_color" rows="20" name="content"><?php echo empty($info['content']) ? '' : $info['content']->content; ?></textarea>
                <input type="hidden" name="id_content" value="<?php echo empty($info['content']) ? '' : $info['content']->id; ?>">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</div>

<!-- modal start -->

<div class="modal fade" id="add_keyword_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">add child keyword belongs to right</h4>
      </div>
      <div class="modal-body">
                <form role="form" action="/doAddKeyword" method="post">
                    {!!csrf_field()!!}
                  <div class="form-group">
                    <label for="exampleInputEmail1">Key Word</label>
                    <input type="text" class="form-control input_color" name="keyword">
                        <input type="hidden" name="id_keyword_parent" value="<?php echo $info['keyword']->id; ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Content</label>
                    <textarea class="form-control input_color" rows="6" name="content"></textarea>
                  </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn_submit">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="add_parent_keyword_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">add parent keyword include right</h4>
      </div>
      <div class="modal-body">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Key Word</label>
                    <input type="text" class="form-control input_color" name="keyword" placeholder="search and choose one">
                  </div>
                  <div class="form-group">
                    <button type="button" class="btn btn-primary" id="search_keyword_btn_1">Search</button>
                  </div>

                <div id="keyword_list_1">

                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- modal end -->
<script type="text/javascript">

pageInitial();

function pageInitial() {

    $('input').on('click',function(){
        $(this).css('background-color','white');
    });

    $('textarea').on('click',function(){
        $(this).css('background-color','white');
    });

    var add_keyword_modal = $('#add_keyword_modal');

    $('#add_keyword_btn').on('click',function(){
        add_keyword_modal.modal('show');
    });

    add_keyword_modal.find('.btn_submit').on('click',function(){
        add_keyword_modal.find('form').submit();
    });

    $('.link_keyword_list_title').on('click',function(){
        $(this).next().slideToggle();
    });

    $('#add_parent_keyword_btn').on('click',function(){
        $('#add_parent_keyword_modal').modal('show');
    });

    $('#search_keyword_btn_1').on('click',function(){
        var search_word = $('#add_parent_keyword_modal').find('input[name="keyword"]').val();
        if (search_word == '') {
            alert('empty key word');
            return false;
        }

        $.post("/ajax_search/keyword",'search_word='+search_word,function(data,status){
            if (status == 'success') {
                console.log(data);
                if (data == '-1') {
                    alert('error parameter');
                }
                else if (data == '') {
                    $('#keyword_list_1').html('no result');
                }
                else{
                    $('#keyword_list_1').html(data);
                    setAddParentKeyWordLink();
                }
            }
            else{
                alert('something wrong');
            }
        });

    });
}

function setAddParentKeyWordLink() {
    var id_keyword = <?php echo $info['keyword']->id; ?>;
    $('#keyword_list_1').find('.add_parent_keyword_link').on('click', function(){
        id_keyword_parent = $(this).attr('id_keyword_parent');

        $.post("/addParentKeyword",'id_keyword='+id_keyword+'&id_keyword_parent='+id_keyword_parent,function(data,status){
            if (status == 'success') {
                if (data == '-1') {
                    alert('something wrong');
                }
                else{
                    window.location.reload();
                }
            }
            else{
                alert('something wrong');
            }
        });
    });
}

</script>

@stop
