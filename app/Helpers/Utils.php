<?php


class Utils
{
    public static function storageFile($url)
    {
        if(!$url) {
            return null;
        }

        return "https://ftp.finanssoreal.com/$url";
    }
}
