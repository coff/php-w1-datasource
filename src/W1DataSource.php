<?php

namespace Coff\DataSource\W1;

use Coff\DataSource\AsyncDataSource;
use Coff\DataSource\StatefulDataSourceInterface;
use Coff\DataSource\StatefulTrait;

abstract class W1DataSource extends AsyncDataSource implements StatefulDataSourceInterface
{
    use StatefulTrait;

    protected $id;

    public function getId() {
        return $this->id;
    }

    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    public function setStamp($timestamp) {
        $this->stamp = $timestamp;

        return $this;
    }

}
