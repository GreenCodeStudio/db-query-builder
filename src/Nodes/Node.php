<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

use Mkrawczyk\DbQueryBuilder\Serializers\Serializer;

abstract class Node
{
    public function getSql(string $string)
    {
        return Serializer::get($string)->serialize($this);
    }

    protected function hasAnyOfChars(string $haystack, string $needle)
    {
        foreach (str_split($needle) as $char) {
            if (str_contains($haystack, $char)) {
                return true;
            }
        }
        return false;
    }
}
