<?php

namespace Craftyx\SlackApi\Contracts;

interface SlackTeam
{
    public function info();
    public function accessLogs($options = []);
}
