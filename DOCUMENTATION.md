# Documentation

## Setup

Initial setup of Elegenta.

    git clone https://github.com/CallumM1999/Eleganta.git eleganta

### Config

The config file can be found in __/Elegentia/app/config/config.php__.

Here, you can change the URL root as well as set the Database config.

### .htaccess

Navigate to __/public/.htaccess__

    <IfModule mod_rewrite.c>
        Options -Multiviews
        RewriteEngine On
        RewriteBase /mvc/Elegenta/
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
    </IfModule>

You must change line 4:

    RewriteBase /mvc/public/

Change the value to the relative path of your project. If you are installing it on a server, it should be __/public/__.

## Routes

At the base of the application, you will find the file routes.php. In this file, you can define the request paths within your application.

Each route is built from three parts, the method, the path, and the controller.

### Route Methods

    Route::get('/settings', 'Base@settings');

The Route method accepts the following methods:

- Get
- Post
- Put
- Patch
- Delete
- Options

Those are specific methods. There are also two less specitic route method types.

The first method is Match, which accepts an array of methods.

    Route::match(['get', 'post'], '/settings', 'Base@settings');

The second method is Any, which will accept any method.

    Route::any('/settings', 'Base@settings');

### Route Paths

If a path is set to an asterisk, it will accept any path.

    Route::get('*', 'Base@settings');

A path can also accept parameters. A parameter is set with curly braces, and the value is returned in the __$params__ array.

    Route::get('/users/{id}', 'Base@settings');

### Route controller

The last part is the controller. The controller is where any logic processing is done and can access the model. The controller then passes this data to the view.

A controller can either be a class method or an inline function.

    Route::get('/settings', 'Base@settings');

Or as an inline function.

    Route::get('/settings', function($request, $params) {
        View::render('settings');
    });

### Route Middleware

Middleware is an optional part of a route. Middleware is a reusable function that is inserted before the controller.

Middleware can either be an inline function or a method in the Middleware class.

    Route::get('/settings', function($request) {

        // Do something
        return $request;

    },'Base@settings');

Or in the Middleware class.

    Route::get('/settings', Middleware::auth, 'Base@settings');

## Controller

Below is the layout for a controller.

__$request__ and __$params__ are passed into each method. The __$request__ array is used by middleware to pass data. The __$params__ array will contain data from encoded URLs.

    namespace Controller;

    use \View as View;

    class Base extends \Controller {
        public function index($request, $params) {
            $data = [
                "title" => "Eleganta",
                "copy" => "A simple PHP MVC framework."
            ];

            View::render('index', $data);
        }
    }

## View

When creating a view, you can either use a normal PHP view or use the templating engine. If you want to use the template engine, you must name the file __view.tmp.php__.

### Default view

Data can be passed through the controller. You can access it from the __$data__ array.

    <h1> <?= $data['title'] ?> </h1>

### Template View

#### Layout

When using the template layout, you have the option to use a parent template. A parent template is a reusable layout, that will accept child content. In the parent template, __@yield__ defines where child content will go.

    <body>

        @include('inc.navbar')

        <div class="container">

            @yield('content')

        </div>
        
    </body>

In the child template, you must use __@extends__ to define the parent template. 

The child template must have corresponding __@content__ tags to the __@yield__ tags found in the parent.

    @extends('inc.base')

    @section('content')

        <p>Hello World!</p>

    @endsection

To include other template files, you can use the __@include__ method. 

#### Logic

The templating language includes many familiar methods, but with a more friendly layout.

##### Echo

To echo data from __$data__, you can use the mustache syntax.

    <h1>{{ $title }}</h1>

##### If

    @if ($score > 6)
        <p>You Win</p>
    @else
        <p>You Lose</p>
    @endif

##### For

    @for($i = 0; $i < 10; $1++)
        <p>Num {{ $i }}</p>
    @endfor

##### Foreach

    @foreach($users as $key => $user) 
        <p>User: {{ $user['name'] }}
    @endforeach

##### Switch

    @switch($name)
        @case('callum')
            <p>Hello Callum</p>
            @break
        @default
            <p>Hello Guest</p>
    @endswitch

## Model

When creating a model, it should extend the BaseModel class. Within a model, you can create methods that interact with the database.

    namespace Model;

    class Base extends \BaseModel {

        public function getUsers() {
            $this->db->query('select * from user');

            $results = $this->db->resultSet();
    
            return $results;
        }   
    }

To access a model from a controller, you must add the following code to the __construct method.

    public function __construct() {
        $this->baseModel = $this->model('Base');
    }

One the Base model is loaded within the controller, you can access its methods.

    public function index() {
        $users = $this->baseModel->etUsers();

        $data = [
            "users" => $users
        ];

        View::render('index', $data);
    }

## Middleware

Middleware can either be an inline function or a method in the Middleware class.

    abstract class Middleware {
        public static function auth($request) {
            $request['auth'] = true;
            
            return $request;
        }
    }

Middleware only accepts one parameter, __$request__. The Request parameter is used when passing data in middleware to the controller. You must remember to return __$request__ in the middleware function.