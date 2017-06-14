<?php

namespace App\Http\Model\Logic;

use Exception;
use App\Http\Model\DB\Garbage_Info_Filter_Model;
use App\Http\Model\DB\Garbage_Info_Param_Model;
use DB;

class GarbageInfoFilter
{
    private $maxUsefulScore = 0.4;
    private $minGarbageScore = 0.6;
    private $countType = ['useful' => 'useful_count', 'garbage' => 'garbage_count'];

    public function classify($string)
    {
        return $this->classification($this->score($this->extractFeatures($string)));
    }

    public function train($string, $type)
    {
        DB::connection()->enableQueryLog();
        $arrayOfGarbageInfoFilterModel = $this->extractFeatures($string);
        foreach ($arrayOfGarbageInfoFilterModel as $G) {
            $this->incrementCount($G, $type);
        }

        $this->incrementTotalCount($type);
        $queries = DB::getQueryLog();
        return;
    }

    private function classification($score)
    {
        if ($score >= $this->minGarbageScore) {
            return ['Garbage', $score];
        } elseif ($score <= $this->maxUsefulScore) {
            return ['Useful', $score];
        } else {
            return ['Unsure', $score];
        }
    }

    public function clearDB()
    {
        Garbage_Info_Filter_Model::truncate();
        Garbage_Info_Param_Model::where('param_type', '=', 'total_garbage_count')->update(['param_value' => '0']);
        Garbage_Info_Param_Model::where('param_type', '=', 'total_useful_count')->update(['param_value' => '0']);
    }

    private function internFeature($word)
    {
        $ret = Garbage_Info_Filter_Model::where('word', '=', $word)->first();
        if (empty($ret)) {
            $ret = new Garbage_Info_Filter_Model();
            $ret->word = $word;
            $ret->save();
            $ret = Garbage_Info_Filter_Model::where('word', '=', $word)->first();
        }

        return $ret;
    }

    private function extractWords($string)
    {
        $pattern = '/[a-zA-Z]{3,}/';
        preg_match_all($pattern, $string, $matches);
        return array_unique($matches[0]);
    }

    private function extractFeatures($string)
    {
        $wordArray = $this->extractWords($string);
        $ret = [];
        foreach ($wordArray as $w) {
            $ret[] = $this->internFeature($w);
        }
        return $ret;
    }

    private function incrementCount($garbageInfoFilterModel, $type)
    {
        if (!in_array($type, $this->countType)) {
            throw new Exception("incrementCount param type error, 1489370761", 1);
        }
        if (empty($garbageInfoFilterModel)) {
            throw new Exception("incrementCount empty garbageInfoFilterModel, 1489370762", 1);
        }

        Garbage_Info_Filter_Model::where('word', '=', $garbageInfoFilterModel['attributes']['word'])->increment($type, 1);
        return;
    }

    private function incrementTotalCount($type)
    {
        if (!in_array($type, $this->countType)) {
            throw new Exception("incrementCount param type error, 1489370763", 1);
        }

        Garbage_Info_Param_Model::where('param_type', '=', 'total_' . $type)->increment('param_value', 1);
        return;
    }

    private function garbageProbability($garbageInfoFilterModel)
    {
        $totalGarbageCount = Garbage_Info_Param_Model::select('param_value')->where('param_type', '=', 'total_garbage_count')->first();
        $totalUsefulCount = Garbage_Info_Param_Model::select('param_value')->where('param_type', '=', 'total_useful_count')->first();
        $totalGarbageCount = max(1, $totalGarbageCount['attributes']['param_value']);
        $totalUsefulCount = max(1, $totalUsefulCount['attributes']['param_value']);

        $garbageFrequency = $garbageInfoFilterModel['attributes']['garbage_count'] / $totalGarbageCount;
        $usefulFrequency = $garbageInfoFilterModel['attributes']['useful_count'] / $totalUsefulCount;

        return $garbageFrequency / ($garbageFrequency + $usefulFrequency);
    }

    private function bayesianGarbageProbability($garbageInfoFilterModel, $assumedProbability = 0.5, $weight = 1)
    {
        $basicProbability = $this->garbageProbability($garbageInfoFilterModel);
        $dataPoints = $garbageInfoFilterModel['attributes']['garbage_count'] + $garbageInfoFilterModel['attributes']['useful_count'];
        $a1 = ($weight * $assumedProbability) + ($dataPoints * $basicProbability);
        $a2 = $weight + $dataPoints;
        return $a1 / $a2;
    }

    private function untrainedWord($garbageInfoFilterModel)
    {
        if (!isset($garbageInfoFilterModel['attributes']['garbage_count']) || !isset($garbageInfoFilterModel['attributes']['useful_count'])) {
            return true;
        }
        elseif ($garbageInfoFilterModel['attributes']['garbage_count'] == 0 && $garbageInfoFilterModel['attributes']['useful_count'] == 0) {
            return true;
        } else {
            return false;
        }
    }

    private function inverseChiSquare($value, $degreesOfFreedom)
    {
        if (($degreesOfFreedom % 2) != 0) {
            throw new Exception("inverseChiSquare $degreesOfFreedom is not even number, 1489370764", 1);
        }
        $m = $value / 2;
        $prob = exp(0 - $m);
        $ret = 0;
        for ($i = 0; $i < ($degreesOfFreedom / 2); ) { 
            $ret += $prob;
            $i++;
            if ($i >= ($degreesOfFreedom / 2)) {
                break;
            }
            $prob = $prob * ($m / $i);
        }

        return min($ret, 1.0);
    }

    private function fisher($probs, $numberOfProbs)
    {
        $a1 = 0;
        foreach ($probs as $v) {
            $a1 += log($v);
        }
        $a1 = $a1 * (0 - 2);
        $a2 = 2 * $numberOfProbs;
        return $this->inverseChiSquare($a1, $a2);
    }

    private function score($arrayOfGarbageInfoFilterModel)
    {
        $garbageProbs = [];
        $usefulProbs = [];
        $numberOfProbs = 0;

        foreach ($arrayOfGarbageInfoFilterModel as $G) {
            if ($this->untrainedWord($G)) {
                continue;
            }

            $garbageProb = $this->bayesianGarbageProbability($G);
            $garbageProbs[] = $garbageProb;
            $usefulProbs[] = 1 - $garbageProb;
            $numberOfProbs++;
        }

        $h = 1 - $this->fisher($garbageProbs, $numberOfProbs);
        $s = 1 - $this->fisher($usefulProbs, $numberOfProbs);
        return ((1 - $h) + $s) / 2;
    }
}
