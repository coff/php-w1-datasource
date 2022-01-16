<?php

namespace Coff\DataSource\W1;

use Coff\OneWire\Client\W1Client;

class W1ServerDataSource extends W1DataSource
{
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function request()
    {
        // what to implement here?

        return $this;
    }

    public function update() {
        if ($this->errorState) {
            throw $this->exception;
        }

        return $this;
    }
}
