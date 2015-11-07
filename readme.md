## Laravel 5 e Lumen - Slack API

[![Join the chat at https://gitter.im/vluzrmos/laravel-slack-api](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/vluzrmos/laravel-slack-api?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

This package provides a simple way to use [Slack API](https://api.slack.com).

[![Latest Stable Version](https://poser.pugx.org/vluzrmos/slack-api/v/stable.svg)](https://packagist.org/packages/vluzrmos/slack-api) [![Total Downloads](https://poser.pugx.org/vluzrmos/slack-api/downloads.svg)](https://packagist.org/packages/vluzrmos/slack-api) [![Latest Unstable Version](https://poser.pugx.org/vluzrmos/slack-api/v/unstable.svg)](https://packagist.org/packages/vluzrmos/slack-api) [![License](https://poser.pugx.org/vluzrmos/slack-api/license.svg)](https://packagist.org/packages/vluzrmos/slack-api)

## Instalation 

`composer require vluzrmos/slack-api`

## Instalation on Laravel 5
Add to `config/app.php`:

```php
<?php 

[
    'providers' => [
        Caftyx\SlackApi\SlackApiServiceProvider::class,
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
        'SlackApi'              => Caftyx\SlackApi\Facades\SlackApi::class,
        'SlackChannel'          => Caftyx\SlackApi\Facades\SlackChannel::class,
        'SlackChat'             => Caftyx\SlackApi\Facades\SlackChat::class,
        'SlackGroup'            => Caftyx\SlackApi\Facades\SlackGroup::class,
        'SlackFile'             => Caftyx\SlackApi\Facades\SlackFile::class,
        'SlackSearch'           => Caftyx\SlackApi\Facades\SlackSearch::class,
        'SlackInstantMessage'   => Caftyx\SlackApi\Facades\SlackInstantMessage::class,
        'SlackUser'             => Caftyx\SlackApi\Facades\SlackUser::class,
        'SlackStar'             => Caftyx\SlackApi\Facades\SlackStar::class,
        'SlackUserAdmin'        => Caftyx\SlackApi\Facades\SlackUserAdmin::class,
        'SlackRealTimeMessage'  => Caftyx\SlackApi\Facades\SlackRealTimeMessage::class,
        'SlackTeam'             => Caftyx\SlackApi\Facades\SlackTeam::class,
    ]
]

?>
```
> The ::class notation is optional.

## Instalation on Lumen

Add that line on `bootstrap/app.php`:

```php
<?php 
// $app->register('App\Providers\AppServiceProvider'); (by default that comes commented)
$app->register('Caftyx\SlackApi\SlackApiServiceProvider');

?>
```

If you want to use facades, add this lines on <code>bootstrap/app.php</code>

```php
<?php

class_alias('Caftyx\SlackApi\Facades\SlackApi', 'SlackApi');
class_alias('Caftyx\SlackApi\Facades\SlackChannel', 'SlackChannel');
class_alias('Caftyx\SlackApi\Facades\SlackChat', 'SlackChat');
class_alias('Caftyx\SlackApi\Facades\SlackGroup', 'SlackGroup');
class_alias('Caftyx\SlackApi\Facades\SlackUser', 'SlackUser');
class_alias('Caftyx\SlackApi\Facades\SlackTeam', 'SlackTeam');
//... and others

?>
```

Otherwise, just use the singleton shortcuts:

```php
<?php

/** @var \Caftyx\SlackApi\Contracts\SlackApi $slackapi */
$slackapi     = app('slack.api');

/** @var \Caftyx\SlackApi\Contracts\SlackChat $slackchat */
$slackchat    = app('slack.chat');

/** @var \Caftyx\SlackApi\Contracts\SlackChannel $slackchannel */
$slackchannel = app('slack.channel');

//or 

/** @var \Caftyx\SlackApi\Contracts\SlackApi $slackapi */
$slackapi  = slack();

/** @var \Caftyx\SlackApi\Contracts\SlackChat $slackchat */
$slackchat = slack('chat'); // or slack('slack.chat')

//...
//...

?>
```

## Configuration

configure your slack team token in <code>config/services.php</code> 

```php 
<?php

[
    //...,
    'slack' => [
        'token' => 'xop-sp-easeu-erahsuer-esrasher'
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

## Using Dependencie Injection

```php
<?php 

namespace App\Http\Controllers;    
    
use Caftyx\SlackApi\Contracts\SlackUser;

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
`Caftyx\SlackApi\Contracts\SlackApi`

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
`Caftyx\SlackApi\Contracts\SlackChannel`

Allows you to operate channels:
`invite`, `archive`, `rename`, `join`, `kick`, `setPurpose` ...


### Chat API
`Caftyx\SlackApi\Contracts\SlackChat`

Allows you to send, update and delete messages with methods:
`delete`, `message`, `update`.

### Files API
`Caftyx\SlackApi\Contracts\SlackFile`

Allows you to send, get info, delete,  or just list files:
`info`, `lists`, `upload`, `delete`.

### Groups API
`Caftyx\SlackApi\Contracts\SlackGroup`

Same methods of the SlackChannel, but that operates with groups and have adicional methods:
`open`, `close`, `createChild`

### Instant Messages API (Direct Messages)
`Caftyx\SlackApi\Contracts\SlackInstantMessage`

Allows you to manage direct messages to your team members.

### Real Time Messages API
`Caftyx\SlackApi\Contracts\SlackRealTimeMessage`

Allows you list all channels and user presence at the moment.


### Search API
`Caftyx\SlackApi\Contracts\SlackSearch`

Find messages or files.

### Stars API
`Caftyx\SlackApi\Contracts\SlackStar`

List all of starred itens.

### Team API
`Caftyx\SlackApi\Contracts\SlackTeam`

Get information about your team.

### Users API
`Caftyx\SlackApi\Contracts\SlackUser`

Get information about an user on your team or just check your presence ou status.

### Users Admin API
`Caftyx\SlackApi\Contracts\SlackUserAdmin`

Invite new members to your team.

## License

[DBAD License](https://dbad-license.org).
