<?php 
namespace se468\Kakaopay;

class Kakaopay
{
    public static $adminKey;
    public static $accessToken;

    public static $apiBaseUrl = "https://kapi.kakao.com";


    public static function getAccessToken()
    {
        return self::$accessToken;
    }

    public static function setAccessToken($accessToken)
    {
        self::$accessToken = $accessToken;
    }

    public static function getAdminKey()
    {
        return self::$adminKey;
    }

    public static function setAdminKey($adminKey)
    {
        self::$adminKey = $adminKey;
    }
}
