<?php
class Utilities
{
    public static function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }

    public static function createRandomKey($amount){
        $keyset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $randkey = "";
        for ($i=0; $i<$amount; $i++)
        $randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
        return $randkey;
    }
}
?>
