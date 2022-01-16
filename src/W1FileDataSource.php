<?php

namespace Coff\DataSource\W1;

use Coff\DataSource\Exception\DataSourceException;

class W1FileDataSource extends W1DataSource {

    /**
     * Directory where to look for device handles
     *
     * @var string
     */
    protected $devicesDir;

    /**
     * Path for specific device
     *
     * @var string
     */
    protected $devicePath;

    public function __construct($idOrFullPath, $devicesDir = '/sys/devices/w1_bus_master1')
    {
        $this->devicesDir = $devicesDir;

        if (false === strstr($idOrFullPath, '/')) {
            $this->id = $idOrFullPath;
            $this->devicePath = $this->devicesDir . '/' . $this->id . '/w1_slave';
        } else {
            $idOrFullPath = strtr($idOrFullPath, array('/w1_slave' => ''));
            $this->id = substr(strrchr(rtrim($idOrFullPath, '/'), '/' ),1);
            $this->devicePath = $idOrFullPath . '/w1_slave';
        }
    }

    public function request()
    {
        if (false == file_exists($this->devicePath)) {
            $this->errorState = true;
            throw $this->exception = new DataSourceException(
                "Data source file not available. Device broken or disconnected?",
                $this->devicePath);
        }

        $this->stream = popen('cat ' . $this->devicePath, 'r');

        if (false === $this->stream) {
            $this->errorState = true;
            throw $this->exception = new DataSourceException(
                "Couldn't open process stream ", $this->devicePath);
        }

        $res = stream_set_blocking($this->stream, false);
        if (false === $res) {
            $this->errorState = true;
            throw $this->exception = new DataSourceException(
                "Couldn't set non-blocking mode for stream", $this->devicePath);
        }

        $this->resetErrorState();

        return $this;
    }

    public function update()
    {
        if (true === $this->errorState) {
            return false;
        }

        if (false === is_resource($this->stream)) {
            throw new DataSourceException('Stream is not a resource!');
        }

        $s = '';
        while (!feof($this->stream)) {
            $s.= fread($this->stream, 2048);
        }

        $this->value = $s;
        $this->stamp = time();

        pclose($this->stream);

        return $this;
    }

    public function getDevicePath() {
        return $this->devicePath;
    }
}
