<?php

namespace App\Service\ShortCode;

/**
 * This is a simple example of generator for short codes
 * Simply converts i with base 10 to some str with base 62
 *
 * Class ShortCodeGenerator
 * @package App\Service\Url
 */
class ShortCodeGenerator implements ShortCodeInterface
{
    public $dictionary = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    public function __construct()
    {
        $this->dictionary = str_split($this->dictionary);
    }

    /**
     * Generates a unique code based on provided integer $i
     *
     * @param int $i
     * @return mixed|string
     */
    public function generateCode(int $i)
    {
        if ($i == 0) {
            return $this->dictionary[0];
        }

        $result = [];
        $base = count($this->dictionary);

        while ($i > 0) {
            $result[] = $this->dictionary[($i % $base)];
            $i = floor($i / $base);
        }

        $result = array_reverse($result);

        return join("", $result);
    }
}
