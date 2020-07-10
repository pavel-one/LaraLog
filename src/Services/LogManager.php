<?php

namespace LaraSU\Logger\Services;

use Illuminate\Log\LogManager as BaseManager;

class LogManager extends BaseManager
{
    public function __construct($app)
    {
        parent::__construct($app);
    }
}