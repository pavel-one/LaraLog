<?php

namespace LaraSU\Logger\Services;

use RuntimeException;

class LaraLog
{
    protected $login;
    protected $token;
    protected $version;
    protected $url;

    public $channel;

    public function __construct(array $config)
    {
        if (!$this->login = $config['login']) {
            throw new RuntimeException('Не задан логин для обращения на сервис'); //TODO: Translate
        }

        if (!$this->token = $config['token']) {
            throw new RuntimeException('Не задан токен для обращения на сервис'); //TODO: Translate
        }

        $this->version = $config['token'] ?? '1.0';
        $this->url = $config['url'] ?? 'https://log.lara.su/api/';
        $this->channel = null;
    }

    public function setChannel($channel): LaraLog
    {
        $this->channel = $channel;

        return $this;
    }

    public function request(array $data)
    {
        $string = http_build_query($data);
    }

    public function log(string $level, string $msg, array $data = []): bool
    {

        return true;
    }

    public function emergency(string $msg, array $data = []): bool
    {
        return $this->log('emergency', $msg, $data);
    }

    public function alert(string $msg, array $data = []): bool
    {
        return $this->log('alert', $msg, $data);
    }

    public function critical(string $msg, array $data = []): bool
    {
        return $this->log('critical', $msg, $data);
    }

    public function error(string $msg, array $data = []): bool
    {
        return $this->log('error', $msg, $data);
    }

    public function warning(string $msg, array $data = []): bool
    {
        return $this->log('warning', $msg, $data);
    }

    public function notice(string $msg, array $data = []): bool
    {
        return $this->log('notice', $msg, $data);
    }

    public function info(string $msg, array $data = []): bool
    {
        return $this->log('info', $msg, $data);
    }

    public function debug(string $msg, array $data = []): bool
    {
        return $this->log('debug', $msg, $data);
    }
}