@extends('layout/admin_layout')
@section('content')

<div class="row" style="padding:10px;">
    <div class="col-sm-12">
        <table class="table">
            <tr>
                <td>耗时：{{ $data->took }}</td>
                <td>共找到：{{ $data->hits->total }}</td>
            </tr>
            <tr>
                <th>
                    Key Word
                </th>
                <th>
                    Click Number
                </th>
                <th>
                    content
                </th>
            </tr>
            <?php foreach ($data->hits->hits as $key1 => $value1) {  ?>
                <tr>
                    <td>
                        <a href="/detail?id_keyword=<?php echo $value1->_id; ?>"> <?php echo $value1->_source->keyword; ?> </a>
                    </td>
                    <td>
                        <?php echo $value1->_source->click_number; ?>
                    </td>
                    <td>
                        <textarea class="form-control" rows="5">
                            {{ $value1->_source->content }}
                        </textarea>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

@stop
