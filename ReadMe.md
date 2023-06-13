1. OVERVIEW  
  This is a Laravel package that retrieves 5-day weather forecast data for a guest identified solely by their IP address. The package is designed to be standalone, allowing for easy installation in any Laravel project.

    When a user inputs their IP address, the package obtains the corresponding latitude and longitude information. The package supports two types of weather forecast services: `DWD-ICON` and `NOAA-GFS`. The user can choose either of these services and input a start date for the forecasting. If no starting date is provided, the package sets the current date as the default.

    Upon clicking the `Weather Forecast` button, the package attempts to retrieve the forecast data based on the IP address, start date, and selected forecasting service. If the package fails to obtain the forecasting data, it returns the message `There is no available forecast data.`

    The package pre-fills the IP address input field with a default IP address, but users can input any IP address they wish.

2. How to intsall:  
    - Update the `composer.json` file in your Laravel project. Locate the `root/composer.json` file and copy the following code snippet into it:
    
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


    - Execute following commands in sequence.
      ```
      composer update
      php artisan vendor:publish --tag=iplocation-migrations
      php artisan vendor:publish --tag=weatherforecast-config
      php artisan vendor:publish --tag=assets
      php artisan migrate
      ```