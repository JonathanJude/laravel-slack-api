<?php

namespace Caftyx\SlackApi\Contracts;

interface SlackUserAdmin
{
    public function invite($email, $options = []);
}
