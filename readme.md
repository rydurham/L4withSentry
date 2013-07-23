## Laravel 4 with Sentry 2 and Bootstrap

This is a demo of [Sentry 2](https://github.com/cartalyst/sentry) integrated with [Laravel 4](https://github.com/laravel/laravel/tree/develop) and [Bootstrap](http://twitter.github.com/bootstrap/index.html).


### Instructions

After you have cloned this repo to your development environment, [install & run composer](http://niallobrien.me/2013/03/installing-and-updating-laravel-4/): 

	curl -sS https://getcomposer.org/installer | php
	php composer.phar install

Next, run the Sentry 2 Migrations: 

	php artisan migrate --package=cartalyst/sentry

Use the seeds provided in this repo to set up the initial user accounts: 

	php artisan db:seed

Edit the /app/config/mail.php to work for your dev environment and then you should be good to go. 

### Seeds
The seeds in this repo will create two groups and two user accounts.

__Groups__
* Users
* Admins

__Users__
* user@user.com  *Password: sentryuser*
* admin@admin.com *Password: sentryadmin*

### Notes

* Please let me know if you have any problems.  
* Sentry 2 is still in active development - I will strive to keep this project updated as they move towards a stable release. 
* There are several Sentry 2 features that I have not included here (mainly User Specific Permissions and Banning).  I will add these eventually.
* The GroupController is restful and the UserController is not; only because I wanted to experiment with both methods.
* I have been a bit sloppy with how I handle "Admin" access checking in the UserController - I hope to clean this up soon.
* There are currently no tests here, beyond the tests provided with Sentry 2 and Laravel 4.  I am not yet hip enough to TDD to add these in a meaningful way.
* Currently all mail is being sent inline - eventually I will switch this over to use the new Queue feature in Laravel 4.


=======
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
