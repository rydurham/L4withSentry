## Laravel 4 with Sentry 2

This is a demo of [Sentry 2]() integrated with [Laravel 4](). 


#### Instructions

After you have cloned this repo to your development environment, run

	php composer.phar update 

Then run the Sentry Migrations: 

	php artisan migrate --package=cartalyst/sentry

Next use the seeds provided in this repo to set up the initial user accounts: 

	php artisan db:seed

After that you should be good to go. 

#### Seeds
The seeds in this repo will create two groups and two user accounts.

__Groups__
* Users
* Admins

__Users__
* user@user.com  *Password: sentryuser*
* admin@admin.com *Password: sentryadmin*

#### Notes

* Please let me know if you have any problems.  Sentry 2 is still in active development - I will strive to keep this project updated as they move towards a stable release. 
* The gGroupController is restful and the UserController is not.  This is only because I wanted to experiment with both methods.
* I have been a bit sloppy with how I handle "Admin" access checking in the UserController - I hope to clean this up eventually.
* There are currently no tests here, beyond the tests provided with Sentry 2 and Laravel 4.  
* Currently all mail is being sent directly inline.  Eventually I will switch this over to use the new Queue feature in Laravel 4.