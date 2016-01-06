<?php

namespace Craftyx\SlackApi\Contracts;

interface SlackReaction
{
    public function add($name, $channel, $timestamp, $file = null, $fileComment = null);
    public function get($channel, $timestamp, $full = true, $file = null, $fileComment = null);
    public function list($user, $full = true, $count = 100, $page = 1);
    public function remove($name, $channel, $timestamp, $file = null, $fileComment = null);
}
