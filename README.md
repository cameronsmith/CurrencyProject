# CurrencyProject
A Laravel project to get currency exchange rates

The application uses homestead. Follow these instructions to setup the server.

1. copy `.env.example` to `.env`
2. run `composer install`
3. run `./vendor/bin/homestead make`
4. `vagrant up`
5. cd /home/vagrant/Code
6. `php artisan key:generate`
7. `php artisan migrate`
 
The site should now be available at: `http://localhost:8000`


If you encounter an issue with composer's SSL certificate make sure you have installed the 
latest version of homestead by running: `vagrant box update`