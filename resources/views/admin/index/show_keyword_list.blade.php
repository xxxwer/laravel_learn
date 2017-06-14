@extends('layout/admin_layout')
@section('content')

<div class="row" style="padding:10px;">
    <div class="col-sm-12">
        <table class="table">
            <tr>
                <th>
                    Key Word
                </th>
                <th>
                    Click Number
                </th>
            </tr>
            <?php foreach ($data as $key1 => $value1) {  ?>
                <tr>
                    <td>
                        <a href="/detail?id_keyword=<?php echo $value1->id; ?>"> <?php echo $value1->keyword; ?> </a> 
                    </td>
                    <td>
                        <?php echo $value1->click_number; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

@stop
