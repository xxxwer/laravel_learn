<?php

namespace App\Library;

use DB;

class ExportESjson
{
    public function __construct($database, $table)
    {
    }

    public function exportJson()
    {
        // $data = DB::table($table)->get();

        curl_setopt_array($this->ch,$this->options);
        $result = curl_exec($this->ch);
        echo "<pre><hr>";
print_r($result);
echo '<hr>'.__LINE__.' '.__FILE__;

        curl_close($this->ch);
        die();
    }

}
