<?php

namespace Craftyx\SlackApi\Methods;

use Craftyx\SlackApi\Contracts\SlackChannel;

class Reaction extends SlackMethod
{
    protected $methodsGroup = "reactions.";

    /**
     * This method adds a reaction (emoji) to an item (file, file comment,
     * channel message, group message, or direct message). One of file,
     * file_comment, or the combination of channel and timestamp must be specified.
     *
     * @see https://api.slack.com/methods/reactions.add
     *
     * @param string $name        Reaction to add
     * @param string $channel     Channel where the message is in
     * @param string $timestamp   Timestamp of the message you are reacting to
     * @param string $file        File id you are reacting to
     * @param string $fileComment Comment id for a file you are reacting to
     *
     * @return array
     */
    public function add($name, $channel, $timestamp, $file = null, $fileComment = null)
    {
        $options = ['name' => $name];
        
        if ( null !== $file && null !== $fileComment ) {
            $options['file'] = $file;
            $options['file_comment'] = $fileComment;
        } else {
            $options['channel'] = $channel;
            $options['timestamp'] = $timestamp;
        }
        
        return $this->method('add', $options);
    }

    /**
     * This method returns a list of all reactions for a single item (file,
     * file comment, channel message, group message, or direct message).
     *
     * @see https://api.slack.com/methods/reactions.get
     *
     * @param string  $channel     Channel where the message is in
     * @param string  $timestamp   Timestamp of the message you are reacting to
     * @param boolean $full        If the complete reaction list should be returned
     * @param string  $file        File id you are reacting to
     * @param string  $fileComment Comment id for a file you are reacting to
     *
     * @return array
     */
    public function get($channel, $timestamp, $full = true, $file = null, $fileComment = null)
    {
        $options = ['channel' => $channel, 'timestamp' => $timestamp, 'full' => $full];

        if ( null !== $file && null !== $fileComment ) {
            $options['file'] = $file;
            $options['file_comment'] = $fileComment;
        } else {
            $options['channel'] = $channel;
            $options['timestamp'] = $timestamp;
        }

        return $this->method('get', $options);
    }

    /**
     * This method returns a list of all items (file, file comment, channel message,
     * group message, or direct message) reacted to by a user.
     * @see https://api.slack.com/methods/reactions.list
     *
     * @param string  $user User to fetch list for.
     * @param boolean $full If the full list should be returned.
     * @param int     $count Number of results per page returned
     * @param int     $page Number of page to request
     *
     * @return array
     */
    public function lists($user, $full = true, $count = 100, $page = 1)
    {
        return $this->method('list', compact('user', 'full', 'count', 'page'));
    }

    /**
     * This method removes a reaction (emoji) from an item (file, file comment, 
     * channel message, group message, or direct message). One of file, file_comment,
     * or the combination of channel and timestamp must be specified.
     *
     * @see https://api.slack.com/methods/channels.info
     *
     * @param string $name        Reaction to remove
     * @param string $channel     Channel where the message is in
     * @param string $timestamp   Timestamp of the message you are removing the reaction from
     * @param string $file        File id you are removing the reaction from
     * @param string $fileComment Comment id for a file you are removing the reaction from
     *
     * @return array
     */
    public function remove($name, $channel, $timestamp, $file = null, $fileComment = null)
    {
        $options = ['name' => $name];

        if ( null !== $file && null !== $fileComment ) {
            $options['file'] = $file;
            $options['file_comment'] = $fileComment;
        } else {
            $options['channel'] = $channel;
            $options['timestamp'] = $timestamp;
        }

        return $this->method('remove', $options);
    }

}
