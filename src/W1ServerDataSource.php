<?php

namespace Coff\OneWire\DataSource;

use Coff\OneWire\Client\W1Client;

class W1ServerDataSource extends W1DataSource
{

    /**
     * @var W1Client
     */
    protected $client;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setClient(W1Client $client) {
        $this->client = $client;

        return $this;
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
