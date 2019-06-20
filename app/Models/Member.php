<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public $test = 'test';
    protected $a;
    protected $c;

    public function test()
    {

    }
    public function __toString()
    {
        $tmp = [];
        dd(get_class_vars(__CLASS__));
        $vars = get_object_vars($this);
        var_dump($vars);die;
        foreach ($vars as $var => $val) {
            if (is_array($val)) {
                $val = json_encode($val);
            }
            $tmp[] = "[{$var}=>{$val}]";
        }
        return implode("\n", $tmp);
    }
}
