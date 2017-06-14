<?php

namespace App\Http\Model\Logic;

use App\Http\Model\DB\Keyword_Model;
use App\Http\Model\DB\Content_Model;
use App\Http\Model\DB\Keyword_Link_Content_Model;
use App\Http\Model\DB\Keyword_Link_Keyword_Model;
use App\Library\ESCommand;
use Exception;

class Keyword_Content_Logic_Model
{
    public function __construct()
    {

    }

    public function addKeywordContent($data)
    {
        $Keyword_Model = new Keyword_Model();
        $Content_Model = new Content_Model();
        $Keyword_Link_Content_Model = new Keyword_Link_Content_Model();

        $ret = $Keyword_Model::where('keyword', '=', $data['keyword'])->get();

        if (!empty($ret->all() )) {
            throw new Exception("already has the keyword 1477301413", 1);
        }
        if (empty($data['keyword']) ) {
            throw new Exception("empty keyword 1477301414", 1);
        }
        $Keyword_Model->keyword = $data['keyword'];
        $Keyword_Model->save();
        $id_keyword = $Keyword_Model->id;

        if (!empty($data['content']) ) {
            $Content_Model->content = $data['content'];
            $Content_Model->save();
            $id_content = $Content_Model->id;
            $Keyword_Link_Content_Model->id_keyword = $id_keyword;
            $Keyword_Link_Content_Model->id_content = $id_content;
            $Keyword_Link_Content_Model->save();
        }

        if (empty($data['id_keyword_parent'])) {
            $data['id_keyword_parent'] = 0;
        }
        $this->addNewKeywordLink($data['id_keyword_parent'], $id_keyword);

        return array('status' => 'success', 'reason' => '', 'content' => array('id_keyword' => $id_keyword));
    }

    public function addNewKeywordLink($id_keyword_parent, $id_keyword)
    {
        $Keyword_Link_Keyword_Model = new Keyword_Link_Keyword_Model();
        $ret = $Keyword_Link_Keyword_Model::where('id_keyword_parent', '=', $id_keyword_parent)->where('id_keyword', '=', $id_keyword)->get();
        if ($ret->count() > 0) {
            return;
        }
        $Keyword_Link_Keyword_Model->id_keyword_parent = $id_keyword_parent;
        $Keyword_Link_Keyword_Model->id_keyword = $id_keyword;
        $Keyword_Link_Keyword_Model->save();
        return;
    }

    public function getKeywordDetail($data)
    {
        if (empty($data['id_keyword']) || !is_numeric($data['id_keyword']) ) {
            throw new Exception("error request parameter 1477301415", 1);
        }

        $info = $this->getKeywordBasicInfo($data['id_keyword']);

        $info['parent_keyword'] = $this->getParentKeyword($data['id_keyword']);
        $info['same_level_keyword'] = $this->getSameLevelKeyword($info['parent_keyword']);
        $info['child_keyword'] = $this->getChildKeyword($data['id_keyword']);

        return array('content' => $info);
    }

    public function getSameLevelKeyword($parentKeywordArray)
    {
        $sameLevelKeyword = [];
        foreach ($parentKeywordArray as $p) {
            $sameLevelKeyword[$p->keyword] = $this->getChildKeyword($p->id);
        }

        return $sameLevelKeyword;
    }

    public function getKeywordBasicInfo($idKeyword)
    {
        $Keyword_Model = new Keyword_Model();
        $Content_Model = new Content_Model();
        $Keyword_Link_Content_Model = new Keyword_Link_Content_Model();

        $temp = $Keyword_Model::where('id', '=', $idKeyword)->get()->all();
        if (empty($temp)) {
            throw new Exception('do not have this keyword id', 1);
        }

        $info['keyword'] = $temp[0];
        $info['keyword']->click_number += 1;
        $info['keyword']->save();

        $temp = $Keyword_Link_Content_Model::where('id_keyword', '=', $idKeyword)->get()->all();

        if (count($temp) > 1) {
            throw new Exception('one keyword links to several contents 1477301416', 1);
        }
        else if (empty($temp) ) {
            $info['keyword_link_content_info'] = '';
            $info['content'] = '';
        }
        else {
            $info['keyword_link_content_info'] = $temp[0];

            $temp = $Content_Model::where('id', '=', $info['keyword_link_content_info']->id_content)->get()->all();
            $info['content'] = $temp[0];
        }

        return $info;
    }

    public function getIdKeywordByIdContent($id_content)
    {
        $temp = Keyword_Link_Content_Model::where('id_content', '=', $id_content)->get()->all();
        if (count($temp) > 1) {
            throw new Exception("one keyword links to several contents 1477301417", 1);
        } else if (count($temp) < 1) {
            throw new Exception("no keyword links to this contents 1477301418", 1);
        }
        return $temp[0];
    }

    public function getParentKeyword($id_keyword)
    {
        $Keyword_Link_Keyword_Model = new Keyword_Link_Keyword_Model();
        $Keyword_Model = new Keyword_Model();

        $temp = $Keyword_Link_Keyword_Model::where('id_keyword', '=', $id_keyword)->get()->all();

        $parent_keyword = array();
        if (empty($temp) ) {
            $this->addNewKeywordLink(0, $id_keyword);
            return $parent_keyword;
        }

        foreach ($temp as $key1 => $value1) {
            $temp2 = $Keyword_Model::where('id', '=', $value1->id_keyword_parent)->get()->all();
            $parent_keyword[$value1->id_keyword_parent] = $temp2[0];
        }

        return $parent_keyword;
    }

    public function getChildKeyword($id_keyword)
    {
        $Keyword_Link_Keyword_Model = new Keyword_Link_Keyword_Model();
        $Keyword_Model = new Keyword_Model();

        $temp = $Keyword_Link_Keyword_Model::where('id_keyword_parent', '=', $id_keyword)->get();
        $temp = $temp->all();

        $child_keyword = array();

        if (empty($temp) ) {
            return $child_keyword;
        }

        foreach ($temp as $key1 => $value1) {
            $temp2 = $Keyword_Model::where('id', '=', $value1->id_keyword)->get()->all();
            $child_keyword[$value1->id_keyword] = $temp2[0];
        }

        return $child_keyword;
    }


    public function updateKeywordContent($data)
    {
        if (empty($data['keyword']) || empty($data['id_keyword'])) {
            throw new Exception("Error, empty keyword or id_keyword 1488792710", 1);
        }

        if (empty($data['content']) ) {
            $data['content'] = 'null';
        }

        if (!empty($data['id_keyword_link_content_info'])) {
            $this->updateKeywordContentAlreadyHasOldValue($data);
        }
        else{
            $this->updateKeywordAddNewContent($data);
        }

        return;
    }

    public function updateKeywordContentAlreadyHasOldValue($data)
    {
        $Keyword_Model = new Keyword_Model();
        $Content_Model = new Content_Model();

        $Keyword_Model->where('id', '=', $data['id_keyword'])->update(['keyword' => $data['keyword'] ] );
        $Content_Model->where('id', '=', $data['id_content'])->update(['content' => $data['content'] ] );
    }

    public function updateKeywordAddNewContent($data)
    {
        $Keyword_Model = new Keyword_Model();
        $Content_Model = new Content_Model();
        $Keyword_Link_Content_Model = new Keyword_Link_Content_Model();

        $Keyword_Model->where('id', '=', $data['id_keyword'])->update(['keyword' => $data['keyword'] ] );
        $Content_Model->content = $data['content'];
        $Content_Model->save();
        $id_content = $Content_Model->id;
        $Keyword_Link_Content_Model->id_keyword = $data['id_keyword'];
        $Keyword_Link_Content_Model->id_content = $id_content;
        $Keyword_Link_Content_Model->save();
    }

    public function searchKeyword($str)
    {
        $keyword_model = new Keyword_Model();

        $data = $keyword_model::where('keyword', 'like', '%'.$str.'%')->orderBy('click_number', 'desc')->take(50)->get();
        $data = $data->all();

        return $data;
    }

    public function deleteKeywordLink($id_keyword_parent, $id_keyword)
    {
        $Keyword_Link_Keyword_Model = new Keyword_Link_Keyword_Model();
        $ret = $Keyword_Link_Keyword_Model::where('id_keyword', '=', $id_keyword)->get();
        $count = $ret->count();
        // parent keyword 只有 root 时 什么也不做
        if ($id_keyword_parent == 0 && $count <= 1) {
            return;
        }

        $Keyword_Link_Keyword_Model::where('id_keyword_parent', '=', $id_keyword_parent)
            ->where('id_keyword', '=', $id_keyword)
            ->delete();

        // 当删除 parent keyword后 没有 parent，自动添加 root 的 parent 链接
        if ($count <= 1) {
            $this->addNewKeywordLink(0, $id_keyword);
        }

        return;
    }

    public function ESIndexAllKeywordBasicInfo()
    {
        $ESCommand = new ESCommand();
        $ret = Keyword_Model::all();
        $i = 0;
        $command_json = '';
        $json_length_limit = 20;
        $es_response = '';

        foreach ($ret as $value) {
            $data = $this->getKeywordBasicInfo($value->id);
            $data = [
                'id_keyword' => $data['keyword']->id,
                'keyword' => $data['keyword']->keyword,
                'click_number' => $data['keyword']->click_number,
                'id_content' => empty($data['content']) ? '' : $data['content']->id,
                'content' => empty($data['content']) ? '' : $data['content']->content
            ];

            $command_json .= $ESCommand->getESJson('index', 'infinite_link', 'keyword_content', $data['id_keyword'], $data);
            $i += 1;
            if ($i > $json_length_limit) {
                $i = 0;
                $es_response .= $this->runESIndexCommand($command_json, $ESCommand);
                $command_json = '';
            }
        }
        if (!empty($command_json)) {
            $es_response .= $this->runESIndexCommand($command_json, $ESCommand);
        }

        return $es_response;
    }

    private function runESIndexCommand($command_json, $ESCommand)
    {
        $ESCommand->setUrl('http://localhost:9200/_bulk?pretty');
        $ESCommand->setRequest('POST');

        $ESCommand->setJson($command_json);
        $ret = $ESCommand->sendEScommand();

        return $ret;
    }

    public function ESfullTextSearch($search_word)
    {
        $ESCommand = new ESCommand();
        $ESCommand->setUrl('http://localhost:9200/infinite_link/_search?pretty');

        $command_json = '{
          "query": {
            "bool": {
              "should": [
                { "match": { "keyword": "' . $search_word . '" } },
                { "match": { "content": "' . $search_word . '" } }
              ]
            }
          }
        }';

        $ESCommand->setJson($command_json);
        $ret = $ESCommand->sendEScommand();
        if (empty($ret)) {
            throw new Exception("Error, elasticsearch maybe not run. 1488788817", 1);
        }
        return json_decode($ret);
    }

    public function ESQueryJson($json_str, $url = 'http://localhost:9200/infinite_link/_search?pretty')
    {
        $ESCommand = new ESCommand();
        $ESCommand->setUrl($url);

        $ESCommand->setJson($json_str);
        $ret = $ESCommand->sendEScommand();
        if (empty($ret)) {
            throw new Exception("Error, elasticsearch maybe not run. 1488788818", 1);
        }
        return $ret;
    }
}
