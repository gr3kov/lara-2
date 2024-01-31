<?php

namespace App\Http;

class InstaHelper
{
    public static function getInstaData($instagramId, $server)
    {
        $url = 'http://' . $server . '?id=' . $instagramId;
        try {
            $data = file_get_contents($url);
            if ($data == "") {
                return "NOT FOUND";
            } else {
                $dataDecode = json_decode($data, true);
                if ($dataDecode == NULL) {
                    return 'ERROR';
                } else {
                    return $dataDecode;
                }
            }
        } catch (\Exception $ex) {
            $data = 'ERROR';
            return $data;
        }
    }

    public static function getInstaPhoto($data)
    {
        return $data['graphql']['user']['profile_pic_url'];
    }

    public static function getInstaId($data)
    {
        return $data['graphql']['user']['id'];
    }

    public static function getInstaName($name)
    {
        $nameClear = trim($name);
        $nameClear = str_replace('@', '', $nameClear);
        $nameClear = str_replace('www.instagram.com/', '', $nameClear);
        $nameClear = str_replace('instagram.com/', '', $nameClear);
        $nameClear = str_replace('https://www.instagram.com/', '', $nameClear);
        $nameClear = str_replace('https://instagram.com/', '', $nameClear);
        $nameClear = strtolower($nameClear);
        return $nameClear;
    }
}
