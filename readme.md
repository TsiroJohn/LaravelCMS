# LaravelCMS

LaravelCMS is a simple Content Management System.

# Requirements
------------
 - PHP >= 7.1.2
 - Laravel >= 5.6.*

## Features:
* Admin Panel
    * Comments and replies approval
	* Category and article management
    * Upload media
	* Post management
	* TinyMCE WYSIWYG editor with photo uploading features
* Front Blog
    * View posts

## Quick Start:

Clone this repository and install the dependencies.

    $ git clone https://github.com/TsiroJohn/LaravelCMS.git CUSTOM_DIRECTORY && cd CUSTOM_DIRECTORY
    $ composer install
    
Generate an application key and migrate the tables, then seed.

    $ php artisan key:generate
    $ php artisan migrate
    $ php artisan db:seed

Install node and npm 
    
    $ npm install
    $ npm run production

Finally, serve the application.

    $ php artisan serve

Open [http://localhost:8000](http://localhost:8000) from your browser. 
The application comes with default admin with email address `admin@admin.com` and `123456`.