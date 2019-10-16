## Slack API for Laravel 5

This package provides a simple way to use [Slack API](https://api.slack.com). It's based on the excellent [Vluzrmos](https://github.com/vluzrmos) package, but it's compatible with Guzzle6

## Instalation 

`composer require vluzrmos/slack-api`

## Instalation on Laravel 5
Add to `config/app.php`:

```php
<?php 

[
    'providers' => [
        Craftyx\SlackApi\SlackApiServiceProvider::class,
    ]
]

?>
```
> The ::class notation is optional.


and add the Facades to your aliases, if you need it

```php
<?php

[
    'aliases' => [
        'SlackApi'              => Craftyx\SlackApi\Facades\SlackApi::class,
        'SlackChannel'          => Craftyx\SlackApi\Facades\SlackChannel::class,
        'SlackChat'             => Craftyx\SlackApi\Facades\SlackChat::class,
        'SlackGroup'            => Craftyx\SlackApi\Facades\SlackGroup::class,
        'SlackFile'             => Craftyx\SlackApi\Facades\SlackFile::class,
        'SlackSearch'           => Craftyx\SlackApi\Facades\SlackSearch::class,
        'SlackInstantMessage'   => Craftyx\SlackApi\Facades\SlackInstantMessage::class,
        'SlackUser'             => Craftyx\SlackApi\Facades\SlackUser::class,
        'SlackStar'             => Craftyx\SlackApi\Facades\SlackStar::class,
        'SlackUserAdmin'        => Craftyx\SlackApi\Facades\SlackUserAdmin::class,
        'SlackRealTimeMessage'  => Craftyx\SlackApi\Facades\SlackRealTimeMessage::class,
        'SlackTeam'             => Craftyx\SlackApi\Facades\SlackTeam::class,
    ]
]

?>
```
> The ::class notation is optional.


## Configuration

configure your slack team token in <code>config/services.php</code> 

```php 
<?php

[
    //...,
    'slack' => [
        'token' => 'your token here'
    ]
]

?>
```

## Usage

```php
<?php

//Lists all users on your team
SlackUser::lists(); //all()

//Lists all channels on your team
SlackChannel::lists(); //all()

//List all groups
SlackGroup::lists(); //all()

//Invite a new member to your team
SlackUserAdmin::invite("example@example.com", [
    'first_name' => 'John', 
    'last_name' => 'Doe'
]);

//Send a message to someone or channel or group
SlackChat::message('#general', 'Hello my friends!');

//Upload a file/snippet
SlackFile::upload([
    'filename' => 'sometext.txt', 
    'title' => 'text', 
    'content' => 'Nice contents',
    'channels' => 'C0440SZU6' //can be channel, users, or groups ID
]);

// Search for files or messages
SlackSearch::all('my message');

// Search for files
SlackSearch::files('my file');

// Search for messages
SlackSearch::messages('my message');

// or just use the helper

//Autoload the api
slack()->post('chat.postMessage', [...]);

//Autoload a Slack Method
slack('Chat')->message([...]);
slack('Team')->info();

?>
```

## Using Dependency Injection

```php
<?php 

namespace App\Http\Controllers;    
    
use Craftyx\SlackApi\Contracts\SlackUser;

class YourController extends Controller{
    /** @var  SlackUser */
    protected $slackUser;
    
    public function __construct(SlackUser as $slackUser){
        $this->slackUser = $slackUser;   
    }
    
    public function controllerMethod(){
        $usersList = $this->slackUser->lists();
    }
}

?>
```

## All Injectable Contracts:

### Generic API
`Craftyx\SlackApi\Contracts\SlackApi`

Allows you to do generic requests to the api with the following http verbs:
`get`, `post`, `put`, `patch`, `delete` ... all allowed api methods you could see here: [Slack Web API Methods](https://api.slack.com/methods).

And is also possible load a SlackMethod contract:

```php
<?php 

/** @var SlackChannel $channel **/
$channel = $slack->load('Channel');
$channel->lists();

/** @var SlackChat $chat **/
$chat = $slack->load('Chat');
$chat->message('D98979F78', 'Hello my friend!');

/** @var SlackUserAdmin $chat **/
$admin = $slack('UserAdmin'); //Minimal syntax (invokable)
$admin->invite('jhon.doe@example.com'); 

?>
```

### Channels API
`Craftyx\SlackApi\Contracts\SlackChannel`

Allows you to operate channels:
`invite`, `archive`, `rename`, `join`, `kick`, `setPurpose` ...


### Chat API
`Craftyx\SlackApi\Contracts\SlackChat`

Allows you to send, update and delete messages with methods:
`delete`, `message`, `update`.

### Files API
`Craftyx\SlackApi\Contracts\SlackFile`

Allows you to send, get info, delete,  or just list files:
`info`, `lists`, `upload`, `delete`.

### Groups API
`Craftyx\SlackApi\Contracts\SlackGroup`

Same methods of the SlackChannel, but that operates with groups and have adicional methods:
`open`, `close`, `createChild`

### Instant Messages API (Direct Messages)
`Craftyx\SlackApi\Contracts\SlackInstantMessage`

Allows you to manage direct messages to your team members.

### Real Time Messages API
`Craftyx\SlackApi\Contracts\SlackRealTimeMessage`

Allows you list all channels and user presence at the moment.


### Search API
`Craftyx\SlackApi\Contracts\SlackSearch`

Find messages or files.

### Stars API
`Craftyx\SlackApi\Contracts\SlackStar`

List all of starred itens.

### Team API
`Craftyx\SlackApi\Contracts\SlackTeam`

Get information about your team.

### Users API
`Craftyx\SlackApi\Contracts\SlackUser`

Get information about an user on your team or just check your presence ou status.

### Users Admin API
`Craftyx\SlackApi\Contracts\SlackUserAdmin`

Invite new members to your team.

## License

[DBAD License](https://dbad-license.org).
