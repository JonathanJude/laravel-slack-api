<?php

namespace Craftyx\SlackApi\Contracts;

interface SlackUserAdmin
{
    public function invite($email, $options = []);
}
