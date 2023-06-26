<?php


namespace App\Http\Services\Identifier;


class Identifier
{
    private $length;
    private $chars;

    public function __construct($length, $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*")
    {
        $this->length = $length;
        $this->chars = $chars;
    }

    public function generate()
    {
        $size = StrLen($this->chars)-1;

        $identifier = "";

        while ($this->length--) {
            $identifier.=$this->chars[rand(0,$size)];
        }

        return $identifier;
    }
}