<?php

class Shorter
{

    public static function encode(String $txt)
    {
        $txt = preg_replace('/(http:\/\/|https:\/\/)/', '', $txt);
        $txt = base64_encode(hash('sha512', uniqid() . $txt . uniqid()));
        $dict = array_merge(range('A', 'Z'), range('a', 'z'), range('A', 'Z'), range('a', 'z'));
        $hash = [];
        $value = 1;
        foreach (str_split($txt) as $idx => $val) {
            $value *= ord($val) * rand(1, 10);
            $value %= 71;
            array_push($hash, $value);
            shuffle($dict);
        }

        $result = '';
        foreach ($hash as $idx => $val) {
            $result .= $dict[$val];
            shuffle($dict);
        }


        return substr($result, random_int(0, 20), 8);
    }
}