<?php

namespace App\Traits;

trait SluggableTrait
{
    public function slugify($string)
    {
        return strtolower(str_replace(array(" ", '_', '-', ',','#', '$', '&', '@', '*', '^', '"', "'"), '-', $string));
    }
}