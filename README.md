# Laravel 8 Event Listener Implementation
 Events provides a simple observer implementation, allowing you to subscribe and listen for events in your application. In this project, here i implement laravel event listener and show that step by step how to sent mail using event in laravel 8.

## Implementation Process
##### 1. Create new laravel project via composer
```
composer create-project laravel/laravel Laravel-Event-Listener-Implementation
```

Go to project directory ```cd Laravel-Event-Listener-Implementation``` or open project with IDE.

##### 2. Create a new database
Here I'm using my MySQL PHPMyAdmin to create a database.<br>
Open ``` .env ``` file and add your database credentials.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=testdb
DB_USERNAME=root
DB_PASSWORD=
```
Run migration artisan command
```
php artisan migrate
```

##### 3. Mail Setup
Open ``` .env ``` file and add your email credentials.
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME='your-mail-user-name'
MAIL_PASSWORD='your-mail-password'
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=example@gmail.com
MAIL_FROM_NAME="Test App"
```
Note: If you don't know mail setup, check my repositories- <br>
https://github.com/mamunurrashid1010/Email-Notification-Laravel8 <br>
https://github.com/mamunurrashid1010/Gmail-Notification-Laravel8 <br>

##### 4. Event Create
``` 
php artisan make:event demoEvent
```
open ``` App\Events\demoEvent.php```  and constructor initialized with user_id
``` 
//add this
public $user_id;
public function __construct($user_id)
{
    $this->user_id = $user_id;
}
```

##### 5. Listener Create for ```App\Events\demoEvent.php``` event
``` 
php artisan make:listener demoListener --event="demoEvent"
```
open ``` App\Listeners\demoListener.php```  and implement sent mail details in handle function
``` 
public function handle(demoEvent $event)
    {
        //add this
        $user = User::find($event->user_id)->toArray();
        $data=['name'=>$user->name, 'bodyData'=>'Thanks for using our application'];
        Mail::send('emails.mailEvent',$data, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Event Testing');
        });
    }
```

##### 6. Register event 
open ```app/Providers/EventServiceProvider.php```  and in $listen array
``` 
use App\Events\demoEvent;
use App\Listeners\demoListener;
protected $listen = [
        // add this
        demoEvent::class => [
            demoListener::class,
        ],
    ]
```

##### 7. Create view ```mail.blade.php``` for mail message body 
open ```mail.blade.php```  and add this
``` 
Hello, {{$name}}<br>
{{$bodyData}}<br><br>

Regards<br>
Mamun
```

##### 8. Create route for send mail
open ```routes\web.php```  and add this
```
Route::get('/sendNotification',function (){
    $user_id=2;
    demoEvent::dispatch($user_id);
});
```

Then run  ```php artisan serve``` & send mail via event ```http://127.0.0.1:8000/sendNotification```
###### Completed.

