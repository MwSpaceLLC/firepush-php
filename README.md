# Push Message <img src="https://www.gstatic.com/devrel-devsite/va3a0eb1ff00a004a87e2f93101f27917d794beecfd23556fc6d8627bba2ff3cf/firebase/images/lockup.png" width="100">
> Small PHP library for send [Cloud Messaging](https://firebase.google.com/docs/cloud-messaging/)

PHP Version  | Status  | Require
------------ | ------  | -------
PHP 7.2      | In Dev  | Composer

> Install Library:

` composer require agent/firepush-php`

> Access Google Firebase Console

Firebase gives you functionality like analytics, databases, messaging and crash reporting
so you can move quickly and focus on your users. (See [Enable Project](https://console.firebase.google.com/))

> Start Agent Object:

```
$firepush = new Agent\Firepush\Service('AAAAWj6Hc4E:LONG-SERVER-CLOUD-MESSAGE-KEY');
```
💻 The class will connect via api to the project in console.firebase.google.com

> Send Signle Device push notice to client

```
$firepush->to('client_token');

$notify = array(
           'title' => 'FCM Message',
           'body' => 'FCM Message Text',
           'icon' => 'http://myproject.com/icon.png',
           'link' => 'http://myproject.com'
         );

$firepush->notification($notify);
                    
$firepush->send();     

//or concatenate:

$firepush->to('client_token')->notification($notify)->send()
               
```
🚀 The system Send the notification in device set in to()


> Send Multiple Device push notice to client

```

$clients_token = array(
// array of token to send
);

$firepush->to($clients_token);

$notify = array(
           'title' => 'FCM Message',
           'body' => 'FCM Message Text',
           'icon' => 'http://myproject.com/icon.png',
           'link' => 'http://myproject.com'
         );

$firepush->notification($notify);
                    
$firepush->send();     

//or concatenate:

$firepush->to($clients_token)->notification($notify)->send()
               
```
🚀 The system Send the notification in ALL device set in to array()


> Retrive Single/Multiple Messages ID

```

CODE FOR SEND NOTIFICETION
                    
$firepush->send();     

// After send:

$firepush->getMessageIds();
               
```
🚀 The system retrive all message id from call
