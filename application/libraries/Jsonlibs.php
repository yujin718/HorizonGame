<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Jsonlibs
{
    public function parseJsontoArray($data, $keywordGroup, $baseKeyword, &$result)
    {
        if (count($keywordGroup) == 0) {
            $content = '';
            foreach ($data as $dt) {
                $content = $content . "," . $dt;
            }
            $result[$baseKeyword] = $content;
            return;
        }
        foreach ($keywordGroup as $key => $value) {
            if (is_array($value)) {
                if ($data == null || !array_key_exists($key, $data)) {
                    continue;
                }
                $keyword = $key;
                if ($baseKeyword != '') {
                    $keyword = $baseKeyword . "_" . $key;
                }
                if (count($value) == 0) {
                    $result[$keyword] = $data[$key];
                } else {
                    $this->parseJsontoArray($data[$key], $value, $keyword, $result);
                }
            } else {
                $keyword = $value;
                if ($baseKeyword != '') {
                    $keyword = $baseKeyword . "_" . $value;
                }
                $result[$keyword] = $data[$value];
            }
        }
    }


    public function parseCharacterJson($filePath)
    {
        $jsonString = file_get_contents($filePath);
        $arrayData = json_decode($jsonString, true);
        if ($arrayData == null) {
            return false;
        }
        return $arrayData;
    }

    public function parseEquipJson($filePath)
    {
        $jsonString = file_get_contents($filePath);
        $arrayData = json_decode($jsonString, true);
        if ($arrayData == null) {
            return false;
        }
        return $arrayData;
    }
    public function parseJson($filePath)
    {
        $jsonString = file_get_contents($filePath);
        $arrayData = json_decode($jsonString, true);
        if ($arrayData == null) {
            return false;
        }
        return $arrayData;
    }
}
