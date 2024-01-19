<?php

namespace Mkrawczyk\DbQueryBuilder\Nodes;

class From extends Node
{
    public SelectQuery|FromSourceTable|RawSQL $source;
    public ?string $alias;

    public function __construct(SelectQuery|FromSourceTable|RawSQL $source, ?string $alias = null)
    {
        $this->source = $source;
        $this->alias = $alias;
    }
}
