<?php

namespace LaraSU\Logger\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class LaraLog
{
    protected $login;
    protected $token;
    protected $version;
    protected $url;

    protected $client;

    protected $queueLogs;

    public $channel;
    public $sync;

    public function __construct(array $config)
    {
        if (!$this->login = $config['login']) {
            throw new RuntimeException('Не задан логин для обращения на сервис'); //TODO: Translate
        }

        if (!$this->token = $config['token']) {
            throw new RuntimeException('Не задан токен для обращения на сервис'); //TODO: Translate
        }

        $this->version = $config['version'] ?? '1.0';
        $this->url = $config['url'] ?? 'https://log.lara.su/api/';
        $this->channel = null;
        $this->sync = $config['sync'] ?? false;

        $this->queueLogs = [];

        $this->client = new Client([
            'base_uri' => $this->url
        ]);
    }

    public function setChannel($channel): LaraLog
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * Отправляет очередь логов на сервер
     *
     * @return ResponseInterface|null
     */
    public function send()
    {
        if (!$this->queueLogs) {
            return null;
        }

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            "version" => $this->version,
            "login" => $this->login,
            "token" => $this->token
        ];

        $request = null;

        try {
            $request = $this->client->post('log', [
                'headers' => $headers,
                'body' => json_encode($this->queueLogs)
            ]);
        } catch (GuzzleException $e) {
            //TODO: Сделать обработку
        }

        $this->refresh();
        return $request;
    }

    /**
     * Добавляет в лог и отправляет при синхронной работе
     *
     * @param string $level
     * @param string $msg
     * @param array $data
     * @return $this|ResponseInterface|null
     */
    public function log(string $level, string $msg, array $data = [])
    {
        $this->addLog([
            'message' => $msg,
            'level' => $level,
            'channel' => $this->channel,
            'data' => $data
        ]);

        if ($this->sync) {
            return $this->send();
        }

        return $this;
    }

    /**
     * Добавляет лог в очередь
     *
     * @param array $data
     * @return $this
     */
    protected function addLog(array $data): self
    {
        $this->queueLogs[] = $data;

        return $this;
    }

    /**
     * Получает очередь логов
     *
     * @return array
     */
    public function getQueue(): array
    {
        return $this->queueLogs;
    }

    /**
     * Сбрасывает очередь логов
     *
     * @return LaraLog
     */
    public function refresh(): self
    {
        $this->queueLogs = [];

        return $this;
    }

    public function emergency(string $msg, array $data = [])
    {
        return $this->log('emergency', $msg, $data);
    }

    public function alert(string $msg, array $data = [])
    {
        return $this->log('alert', $msg, $data);
    }

    public function critical(string $msg, array $data = [])
    {
        return $this->log('critical', $msg, $data);
    }

    public function error(string $msg, array $data = [])
    {
        return $this->log('error', $msg, $data);
    }

    public function warning(string $msg, array $data = [])
    {
        return $this->log('warning', $msg, $data);
    }

    public function notice(string $msg, array $data = [])
    {
        return $this->log('notice', $msg, $data);
    }

    public function info(string $msg, array $data = [])
    {
        return $this->log('info', $msg, $data);
    }

    public function debug(string $msg, array $data = [])
    {
        return $this->log('debug', $msg, $data);
    }

    public function emergencySync(string $msg, array $data = [])
    {
        return $this->log('emergency', $msg, $data)->send();
    }

    public function alertSync(string $msg, array $data = [])
    {
        return $this->log('alert', $msg, $data)->send();
    }

    public function criticalSync(string $msg, array $data = [])
    {
        return $this->log('critical', $msg, $data)->send();
    }

    public function errorSync(string $msg, array $data = [])
    {
        return $this->log('error', $msg, $data)->send();
    }

    public function warningSync(string $msg, array $data = [])
    {
        return $this->log('warning', $msg, $data)->send();
    }

    public function noticeSync(string $msg, array $data = [])
    {
        return $this->log('notice', $msg, $data)->send();
    }

    public function infoSync(string $msg, array $data = [])
    {
        return $this->log('info', $msg, $data)->send();
    }

    public function debugSync(string $msg, array $data = [])
    {
        return $this->log('debug', $msg, $data)->send();
    }
}