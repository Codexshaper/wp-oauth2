<?php

namespace CodexShaper\WP\Support\Facades;

class Config
{
    protected $config = [];

    public function __construct()
    {
        foreach (glob(PLUGIN_BASE_PATH.'/../config/*.php') as $file) {
            $index = pathinfo($file)['filename'];
            $this->config[$index] = require_once $file;
        }
    }

    public function get($config, $default = null)
    {
        $keys = explode('.', $config);
        $filename = array_shift($keys);
        $data = $this->config[$filename];

        foreach ($keys as $key) {
            if (is_array($data) && array_key_exists($key, $data)) {
                $data = $data[$key];
            } else {
                $data = null;
            }
        }

        if (!$data) {
            $data = $default;
        }

        return $data;
    }
}
