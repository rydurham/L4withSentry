## Laravel 4 with Sentry 2 - Version 2.0

This is a demo of [Sentry 2](https://github.com/cartalyst/sentry) integrated with [Laravel 4](https://github.com/laravel/laravel/tree/develop) and [Bootstrap 3.0](http://getbootstrap.com).

Version 2.0 has been completely revamped using strategies suggested in *Laravel: From Apprentics to Artisan* by Taylor Otwell and *Implementing Laravel* by Chris Fidao and the Laracast videos.   Version 1.0 still exists in its original version. 


### Instructions

1. Clone this repo
2. Run ```php composer.phar update```
3. Set up your datbase configuration in ```app/config/database.php```
4. Edit ```app/config/mail.php``` to work with your mail setup.
5. Run the migrations: ```php artisan migrate```
6. Seed the Database: ```php artisan db:seed```

### Seeds
The seeds in this repo will create two groups and two user accounts.

__Groups__
* Users
* Admins

__Users__
* user@user.com  *Password: sentryuser*
* admin@admin.com *Password: sentryadmin*

### Links
* [Sentry 2.0 Documentation](https://cartalyst.com/manual/sentry)
* [Laravel 4 Documentation](http://laravel.com/docs)
* [Laravel: From Apprentice To Artisan](https://leanpub.com/laravel) by Taylor Otwell
* [Implementing Laravel](https://leanpub.com/implementinglaravel) by Chris Fidao
* [Laracasts](http://laracasts.com)

### Notes

* There are several Sentry 2 features that I have not included here (mainly User Specific Permissions and Banning).
* There are currently no tests here, beyond the tests provided with Sentry 2 and Laravel 4.  I am not yet hip enough to TDD to add these in a meaningful way.

=======
The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
