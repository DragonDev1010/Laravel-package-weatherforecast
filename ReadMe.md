- update composer.json
  ```
  "repositories": [
    {
        "type": "vcs",
        "url" : "https://github.com/DragonDev1010/Laravel-package-weatherforecast"
    }
  ],

  "require": {
    "great/weatherforecast": "dev-master",
  },
  ```


- run command

  `composer update`  
  `php artisan vendor:publish --tag=iplocation-migrations`  
  `php artisan vendor:publish --tag=weatherforecast-config`  
  `php artisan vendor:publish --tag=assets`  
  `php artisan migrate`  