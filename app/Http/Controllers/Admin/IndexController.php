<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Model\DB\Keyword_Model;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Model\Logic\Keyword_Content_Logic_Model;
use App\Http\Model\Logic\GarbageInfoFilter;
use Exception;
use Cache;
use App\Library\SphinxClient;
use App\Library\ESCommand;
use App\Contracts\TestContract;
use App;
use App\Library\AbstractFactoryPattern\FactoryProducer;
use App\Library\SingletonPattern\Singleton;
use App\Library\BuilderPattern\MealBuilder;
use App\Library\ObserverPattern\ObserverPatternTest;
use App\Library\CommandPattern\CommandPatternTest;
use App\Library\StrategyPattern\StrategyPatternTest;
use App\Library\ClosureTest\Closure1;

class IndexController extends Controller
{
    public function showKeywordList()
    {
        $keyword_model = new Keyword_Model();

        $list_data = $keyword_model::orderBy('click_number', 'desc')->take(50)->get();
        $list_data = $list_data->all();

        return view('admin/index/show_keyword_list',['data' => $list_data]);
    }

    public function addKeyword($value='')
    {
        return view('admin/index/add_keyword');
    }

    public function doAddKeyword()
    {
        try {
            $input = Input::all();
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $ret = $Keyword_Content_Logic_Model->addKeywordContent($input);
            return Redirect::to('detail?id_keyword='.$ret['content']['id_keyword']);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function showKeywordDetail()
    {
        try {
            $input = Input::all();
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $ret = $Keyword_Content_Logic_Model->getKeywordDetail($input);

            return view('admin/index/show_keyword_detail', ['info' => $ret['content'] ] );
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function updateKeyword()
    {
        try {
            $input = Input::all();
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $ret = $Keyword_Content_Logic_Model->updateKeywordContent($input);

            return Redirect::to('detail?id_keyword='.$input['id_keyword']);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function searchKeyword()
    {
        $input = Input::all();
        if (empty($input['search_word']) ) {
            return Redirect::to('index');
        }

        $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
        $data = $Keyword_Content_Logic_Model->searchKeyword($input['search_word']);

        return view('admin/index/show_keyword_list',['data' => $data]);
    }

    public function fullTextSearchSphinx()
    {
        $input = Input::all();
        if (empty($input['search_word']) ) {
            return Redirect::to('index');
        }

        $sphinx = new SphinxClient();
        $sphinx->setServer("localhost", 9312);
        $sphinx->setMatchMode(SPH_MATCH_ANY);   //匹配模式 SPH_MATCH_ANY为关键词自动拆词，SPH_MATCH_ALL为不拆词匹配（完全匹配）
        $sphinx->SetArrayResult(true);    //返回的结果集为数组
        $result = $sphinx->query($input['search_word'], '*');    //星号为所有索引源

        $data = [];
        if (!empty($result['matches'])) {
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();

            foreach ($result['matches'] as $key => $content) {
                $id_keyword_obj = $Keyword_Content_Logic_Model->getIdKeywordByIdContent($content['id']);
                $keyword = Keyword_Model::where('id', '=', $id_keyword_obj->id_keyword)->get()->all();
                $data[] = $keyword[0];
            }
        }

        return view('admin/index/show_keyword_list',['data' => $data]);
    }

    public function fullTextSearchES()
    {
        $input = Input::all();
        if (empty($input['search_word']) ) {
            return Redirect::to('index');
        }

        try {
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $data = $Keyword_Content_Logic_Model->ESfullTextSearch($input['search_word']);
            // echo("<pre>");
            // var_dump($data);
            // die();
            return view('admin/index/show_es_search_result',['data' => $data]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }

    }

    public function ajaxSearchKeyword()
    {
        $input = Input::all();
        if (empty($input['search_word']) ) {
            echo "-1";
            exit();
        }

        $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
        $data = $Keyword_Content_Logic_Model->searchKeyword($input['search_word']);

        return view('admin/index/ajax_keyword_list',['data' => $data]);
    }

    public function addParentKeyword()
    {
        $input = Input::all();

        if (!is_numeric($input['id_keyword']) || !is_numeric($input['id_keyword_parent']) ) {
            echo "-1";
            exit();
        }

        $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
        $Keyword_Content_Logic_Model->addNewKeywordLink($input['id_keyword_parent'], $input['id_keyword']);

        echo "1";
        exit();
    }

    public function deleteKeywordLink()
    {
        $input = Input::all();
        if (!is_numeric($input['id_keyword']) || !is_numeric($input['id_keyword_parent']) ) {
            return view('errors/show_error', array('title' => 'error', 'content' => 'error parameter 1477489510') );
        }

        $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();

        $Keyword_Content_Logic_Model->deleteKeywordLink($input['id_keyword_parent'], $input['id_keyword']);
        return Redirect::to('detail?id_keyword='.$input['id_keyword']);
    }

    public function rootKeywordList()
    {
        $keyword_model = new Keyword_Model();
        $data = $keyword_model::join('keyword_link_keyword', 'keyword.id', '=', 'keyword_link_keyword.id_keyword')->where('keyword_link_keyword.id_keyword_parent', '=', '0')->select('keyword.*')->orderBy('click_number', 'desc')->take(200)->get();
        $data = $data->all();
        return view('admin/index/show_keyword_list', ['data' => $data]);

    }

    public function ESindexALL()
    {
        try {
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $str = $Keyword_Content_Logic_Model->ESIndexAllKeywordBasicInfo();

            return view('admin/index/other_function', ['result' => $str]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function ESseeHealth()
    {
        try {
            $ESCommand = new ESCommand();
            $str = $ESCommand->sendEScommand();
            return view('admin/index/other_function', ['result' => $str]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function ESIndexStatus()
    {
        try {
            $ESCommand = new ESCommand();
            $ESCommand->setUrl('http://localhost:9200/_cat/indices?v&pretty');
            $str = $ESCommand->sendEScommand();
            return view('admin/index/other_function', ['result' => $str]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function ESQueryJson()
    {
        $input = Input::all();
        if (empty($input['query_json']) ) {
            return Redirect::to('otherFunction');
        }

        try {
            $Keyword_Content_Logic_Model = new Keyword_Content_Logic_Model();
            $data = $Keyword_Content_Logic_Model->ESQueryJson($input['query_json']);
            return view('admin/index/other_function', ['result' => $data, 'query_json' => $input['query_json']]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }

    }

    public function garbageInfoFilter()
    {
        try {
            $input = Input::all();
            if (empty($input['info_string'])) {
                throw new Exception("empty info_string. 1489392224", 1);
            }
            $garbageInfoFilter = new GarbageInfoFilter();
            $ret = $garbageInfoFilter->classify($input['info_string']);
            return view('admin/index/other_function', ['result' => $ret[0] . '|' . $ret[1]]);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function trainGarbageInfoFilter()
    {
        try {
            $garbageInfoFilter = new GarbageInfoFilter();
            $input = Input::all();
            if (empty($input['info_string'])) {
                throw new Exception("empty info_string. 1489392224", 1);
            }
            $ret = $garbageInfoFilter->train($input['info_string'], $input['info_type']);
            return view('admin/index/other_function', ['result' => 'trainGarbageInfoFilter success.']);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function clearGarbageInfoFilterDB($value='')
    {
        try {
            $garbageInfoFilter = new GarbageInfoFilter();
            $input = Input::all();
            if (empty($input['pass']) || $input['pass'] !== 'clear db') {
                throw new Exception("error pass. 1489392225", 1);
            }
            $garbageInfoFilter = new GarbageInfoFilter();
            $garbageInfoFilter->clearDB();
            return view('admin/index/other_function', ['result' => 'clearGarbageInfoFilterDB success.']);
        } catch (Exception $e) {
            return exceptionOperate($e);
        }
    }

    public function otherFunction($param = null)
    {
        if (!empty($param)) {
            $this->$param();
        }

        return view('admin/index/other_function', ['result' => '****']);
    }

    private function AbstractFactoryPattern()
    {
        $shapeFactory = FactoryProducer::getFactory("SHAPE");

        //获取形状为 Rectangle 的对象
        $shape2 = $shapeFactory->getShape("RECTANGLE");

        //调用 Rectangle 的 draw 方法
        $shape2->draw();

        //获取形状为 Square 的对象
        $shape3 = $shapeFactory->getShape("SQUARE");

        //调用 Square 的 draw 方法
        $shape3->draw();

        //获取颜色工厂
        $colorFactory = FactoryProducer::getFactory("COLOR");

        //获取颜色为 Red 的对象
        $color1 = $colorFactory->getColor("RED");

        //调用 Red 的 fill 方法
        $color1->fill();

        //获取颜色为 Green 的对象
        $color2 = $colorFactory->getColor("Green");

        //调用 Green 的 fill 方法
        $color2->fill();
        die();
    }

    private function SingletonPattern(){
        $object = Singleton::getInstance();
        $object->showMessage();
        die();
    }

    private function BuilderPattern(){
        $mealBuilder = new MealBuilder();

        $vegMeal = $mealBuilder->prepareVegMeal();
        echo("Veg Meal");
        $vegMeal->showItems();
        echo("Total Cost: " . $vegMeal->getCost());

        $nonVegMeal = $mealBuilder->prepareNonVegMeal();
        echo("\n\nNon-Veg Meal");
        $nonVegMeal->showItems();
        echo("Total Cost: " . $nonVegMeal->getCost());
        die();
    }

    private function ObserverPattern(){
        $observerPatternTest = new ObserverPatternTest();
        $observerPatternTest->do();
        die();
    }

    private function CommandPattern(){
        $commandPatternTest = new CommandPatternTest();
        $commandPatternTest->do();
        die();
    }

    private function StrategyPattern(){
        $StrategyPatternTest = new StrategyPatternTest();
        $StrategyPatternTest->do();
        die();
    }

    private function Closure1()
    {
        $closure1 = new Closure1();
        $closure1->test();
        die();
    }
}
