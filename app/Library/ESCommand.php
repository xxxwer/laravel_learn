<?php

namespace App\Library;

use DB;
use Exception;

class ESCommand
{
    private $database = '';
    private $table = '';
    private $options = [
        CURLOPT_URL => 'http://localhost:9200/_cat/health?v&pretty',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => '',
        CURLOPT_HTTPHEADER => ['Content-Type: appliaction/json']
    ];
    private $ch;

    public function __construct()
    {
        //
    }

    public function getESJson($command, $index, $type, $id, $source)
    {
        if (!in_array($command, ['index', 'delete', 'create', 'update'])) {
            throw new Exception('error $command:' . $command, 1);
        }
        if (!is_array($source)) {
            throw new Exception('$source should be array', 1);
        }

        $a1 = [$command => [ '_index' => $index, '_type' => $type, '_id' => $id ]];
        $json_str = json_encode($a1) . "\n" . json_encode($source) . "\n";
        return $json_str;
    }


    public function setRequest($value = 'POST')
    {
        $this->options[CURLOPT_CUSTOMREQUEST] = $value;
    }

    public function setJson($value)
    {
        if (empty($value)) {
            $value = '';
        }
        $this->options[CURLOPT_POSTFIELDS] = $value;
    }

    public function setUrl($CURLOPT_URL = 'http://localhost:9200/_cat/health?v&pretty')
    {
        $this->options[CURLOPT_URL] = $CURLOPT_URL;
    }

    public function sendEScommand()
    {
        $this->ch = curl_init();
        curl_setopt_array($this->ch,$this->options);
        $result = curl_exec($this->ch);
        curl_close($this->ch);
        return $result;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
