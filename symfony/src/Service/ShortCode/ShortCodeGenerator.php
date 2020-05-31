<?php


namespace App\Service\ShortCode;

/**
 * This is a simple example of generator for short codes
 *
 * Class ShortCodeGenerator
 * @package App\Service\Url
 */
class ShortCodeGenerator implements ShortCodeInterface
{
    /**
     * Generates a short code by using hex of the current timestamp
     * WARNING: NOT race-condition-safe
     *
     * @return float|int
     */
    public function generateCode(int $id)
    {
        return dechex(time());
    }
}
