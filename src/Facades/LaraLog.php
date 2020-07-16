<?php

namespace LaraSU\Logger\Facades;

use Illuminate\Support\Facades\App;
use LaraSU\Logger\Services\LaraLog as Service;

class LaraLog
{
    /**
     * Устанавливает канал на котором нужно логировать и
     * возвращает сервис логирования для дальнейшего обращения
     *
     * @param string $channel
     * @return Service
     */
    public static function channel(string $channel): Service
    {
        return App::get('LaraLog')->setChannel($channel);
    }

    /**
     * Отправляет на логирование с указанием уровня логирования
     *
     * @param string $level
     * @param string $msg - сообщение
     * @param array $data - массив с данными
     *
     * @return Service|\Psr\Http\Message\ResponseInterface|null
     */
    public static function log(string $level, string $msg, array $data)
    {
        /** @var Service $service */
        $service = App::get('LaraLog');

        if ($service->channel !== null) {
            $service->setChannel(null);
        }

        return $service->log($level, $msg, $data);
    }

    public static function emergency($msg, array $data = [])
    {
        return self::log('emergency', $msg, $data);
    }

    public static function alert($msg, array $data = [])
    {
        return self::log('alert', $msg, $data);
    }

    public static function critical($msg, array $data = [])
    {
        return self::log('critical', $msg, $data);
    }

    public static function error($msg, array $data = [])
    {
        return self::log('error', $msg, $data);
    }

    public static function warning($msg, array $data = [])
    {
        return self::log('warning', $msg, $data);
    }

    public static function notice($msg, array $data = [])
    {
        return self::log('notice', $msg, $data);
    }

    public static function info($msg, array $data = [])
    {
        return self::log('info', $msg, $data);
    }

    public static function debug($msg, array $data = [])
    {
        return self::log('debug', $msg, $data);
    }

    public static function emergencySync($msg, array $data = [])
    {
        return self::log('emergency', $msg, $data)->send();
    }

    public static function alertSync($msg, array $data = [])
    {
        return self::log('alert', $msg, $data)->send();
    }

    public static function criticalSync($msg, array $data = [])
    {
        return self::log('critical', $msg, $data)->send();
    }

    public static function errorSync($msg, array $data = [])
    {
        return self::log('error', $msg, $data)->send();
    }

    public static function warningSync($msg, array $data = [])
    {
        return self::log('warning', $msg, $data)->send();
    }

    public static function noticeSync($msg, array $data = [])
    {
        return self::log('notice', $msg, $data)->send();
    }

    public static function infoSync($msg, array $data = [])
    {
        return self::log('info', $msg, $data)->send();
    }

    public static function debugSync($msg, array $data = [])
    {
        return self::log('debug', $msg, $data)->send();
    }


}