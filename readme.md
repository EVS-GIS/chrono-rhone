<p align="center"><img src="public/images/OHMVR.jpg" style="height:100px;"></p>

# Getting started
This project is based on [Laravel](https://laravel.com) (a modern PHP framework) in its latest LTS version for the API and [Vue.js](https://vuejs.org) for user interface

## Server requirements

### PHP Configuration
The Laravel framework has a few system requirements. It can be installed on Linux or Windows environnement.
- Please check the official laravel installation guide  before you start:  [Official-Documentation](https://laravel.com/docs/6.x)

You need at least :
  - PHP >= 7.2.0
  - BCMath PHP Extension
  - Ctype PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension
  - Zip PHP Extension
  - GD PHP Extension

For this project, we used PostgreSQL as SGBD, so you also need to install the Postgresql PHP 7 Extension php7-pgsql and activate the module by the command : phpenmod pgsql

Laravel utilizes [Composer](https://getcomposer.org/) to manage its dependencies. So, before using Laravel, make sure you have Composer installed on your server.

### Web Server Configuration

Laravel can use Apache2 or Nginx.

For this project, we used Apache2 and we need to enable the mod_rewrite module for pretty URLs

Here a configuration exemple :

        <VirtualHost *:80>                                
        ServerName localhost       
        ServerAlias YOUR DOMAIN         
        DocumentRoot /var/www/chrono-rhone/public        
                                                          
        <Directory "/var/www/chrono-rhone/public">       
                Options FollowSymLinks                   
                Order Allow,Deny                         
                Allow from all                           
                ReWriteEngine On                         
        </Directory>                                     
                                                          
        ErrorLog /var/log/apache2/error.log              
        CustomLog /var/log/apache2/access.log combined   
                                                          
        </VirtualHost>                                    

If you use SSL, you need to install your certificate as in this example:

        <VirtualHost *:443>
          ServerName localhost
          DocumentRoot /var/www/chrono-rhone/public
          <Directory "/var/www/chrono-rhone/public">
            Options +FollowSymLinks +MultiViews
            AllowOverride All
            Require all granted
            ReWriteEngine On
          </Directory>
          SSLCertificateFile /etc/ssl/certs/YOUR_CERTIFICATE.cer
          SSLCertificateKeyFile /etc/ssl/private/YOUR_CERTIFICATE.key
          SSLCertificateChainFile /etc/ssl/certs/YOUR_CERTIFICATE.cer
          #SSLProtocol All -SSLv2 -SSLv3

          ErrorLog ${APACHE_LOG_DIR}/error.log
          CustomLog ${APACHE_LOG_DIR}/access.log combined
        </VirtualHost>

### Database Configuration

In this project, we used PosgreSQL version 12 as SGBD with his geographical extension postGIS version 3.
You can install the database on the same server by the command :

        sudo apt install postgresql-12 postgis postgresql-12-postgis-3

After creating your database, you need to activate postgis with the sql query :

        CREATE EXTENSION postgis;

### Optional : Node.js installation
The Vue.js part is already compiled in the public repository and ready to use. If you need to change domain name or recompiled the Vue.js project, you need to install Node.js
The required Node.js version is 8.9 or above (13.7.0+ recommended). You can manage multiple versions of Node on the same machine with [nvm](https://github.com/creationix/nvm) or [nvm-windows](https://github.com/coreybutler/nvm-windows).

## Installation

- Clone the repository

        git clone git@gitlab.com:chrono-terr.git chrono-rhone

- Switch to the repo folder

        cd chrono-rhone

- Install all the dependencies using composer

        composer install

- Update dependencies if needed

        composer update

- Copy the example .env file and make the required configuration changes in the .env file (database, email, mapbox token, etc...)

        cp .env.example .env
For cartography, this project use the Mapbox library [Mapbox GL JS](https://docs.mapbox.com/mapbox-gl-js/api/). You need an access token tu use it. It's free but you need to create an account and sign in to your Mapbox account to display your access token.
By default, we use the map style publish by data.gouv.fr available at https://openmaptiles.geo.data.gouv.fr. You are free to use another one by changing the environnement variable MIX_MAPBOX_STYLE in your .env file.

- Generate a new application key (You can verify after .env APP_KEY if feeded)

        php artisan key:generate

- Generate a new JWT authentication secret key (You can verify after .env JWT_SECRET if feeded)

        php artisan jwt:secret

- Load .env file with modification

        php artisan config:cache

- Generate a symlink to store image in the public repository

        php artisan storage:link

- Run the database migrations

        php artisan migrate 
         
- Run the seeders to initialize database. It will create a user admin@chrono-rhone.fr with password `admin` and all the rights to start the project.  

        php artisan db:seed
        
- Change files ownership to www-data

        chown www-data:www-data -R *

- Optional : If you need to compiled the Vue.js project, please ensure that Node.js is installed on the serveur and use the following commands :

        npm install
        npm run prod

- Great! The project is now install. You can sign in with the default admin user, create new users, import events by uploading the model of Excel file or begin to create new events, thematics and themes.

# Code overview

## Dependencies
List of all dependencies for Laravel can be find in composer.json file. Required dependencies are :
- [jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens
- [laravel-cors](https://github.com/barryvdh/laravel-cors) - For handling Cross-Origin Resource Sharing (CORS)
- [L5 Swagger](https://github.com/DarkaOnLine/L5-Swagger). - OpenApi or Swagger Specification for Laravel project
- [Laravel Excel](https://github.com/Maatwebsite/Laravel-Excel) Export or Import data with excel, or csv files.

List of all dependencies for Vue.js can be find in package.json file. Required dependencies are :
- [axios](https://www.npmjs.com/package/axios) - Promise based HTTP client for the browser and node.js
- [buefy](https://buefy.org/) - Lightweight UI components for Vue.js based on Bulma CSS framework
- [bulmaswatch](https://jenil.github.io/bulmaswatch)- Free themes for Bulma CSS framework
- [mdi](https://materialdesignicons.com/) - Material Design Icons growing icon collection allows designers and developers targeting various platforms to download icons in the format, color and size they need for any project.
- [jwt-decode](https://www.npmjs.com/package/jwt-decode) - jwt-decode is a small browser library that helps decoding JWTs token which are Base64Url encoded.
- [lodash](https://lodash.com/) - A modern JavaScript utility library delivering modularity, performance & extras.
- [sass](https://sass-lang.com/) - Sass is the most mature, stable, and powerful professional grade CSS extension language in the world. 
- [sass-loader](https://www.npmjs.com/package/sass-loader) - Loads a Sass/SCSS file and compiles it to CSS
- [vee-validate](https://www.npmjs.com/package/vee-validate) - vee-validate is a template-based validation framework for Vue.js that allows you to validate inputs and display errors.
- [vue-router](https://router.vuejs.org/) - Vue Router is the official router for Vue.js 
- [vuex](https://vuex.vuejs.org/) - Vuex is a state management pattern + library for Vue.js applications
- [mapbox-gl](https://docs.mapbox.com/mapbox-gl-js/overview/) - A JavaScript library that uses WebGL to render interactive maps.
- [mapbox-gl-draw](https://github.com/mapbox/mapbox-gl-draw) Adds support for drawing and editing features on mapbox-gl.js maps
- [turf](https://turfjs.org/) - A JavaScript library for advanced geospatial analysis in browsers and Node.js
- [apexcharts](https://apexcharts.com/) ApexCharts is a modern charting library that helps developers to create beautiful and interactive visualizations.
- [vue2-editor](https://github.com/davidroyer/vue2-editor) An easy-to-use rich text editor powered by Quill.js and Vue.js
- [vue-swatches](https://saintplay.github.io/vue-swatches/) A color pickers for Vue.js

## Authentication
This applications uses JSON Web Token (JWT) to handle authentication. The token is passed with each request using the `Authorization` header with `Token` scheme. The JWT authentication middleware handles the validation and authentication of the token. Please check the following sources to learn more about JWT.
- https://jwt.io/introduction/
- https://self-issued.info/docs/draft-ietf-oauth-json-web-token.html

## Cross-Origin Resource Sharing (CORS)
This applications has CORS enabled by default on all API endpoints. The CORS allowed origins can be changed by setting them in the config file. Please check the following sources to learn more about CORS.
- https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
- https://en.wikipedia.org/wiki/Cross-origin_resource_sharing
- https://www.w3.org/TR/cors

## Folders

- `app` - Contains all the Eloquent models
- `app/Http/Controllers/V1` - Contains all the api controllers
- `app/Http/Repositories/V1` - Contains all controllers methods
- `app/Http/Middleware` - Contains the authentication middleware and all methods to verify user rights on end-points
- `app/Http/Requests/V1` - Contains all the api form requests
- `app/Http/Ressources/V1` - Contains all the ressources for formatting data for end-points
- `config` - Contains all the application configuration files
- `database/migrations` - Contains all the database migrations classed by folder
- `database/seeds` - Contains the database seeder to initialize database (Seeder are commented in DatabaseSeeder.php file, please discommented before initializing database)
- `ressources` - Contains all Vue.js files (front office)
- `routes` - Contains all the api routes defined in api.php file
- `public` - Contains all public files and front office compiled files

## API Documentation

The documentation is generated by swagger. Each opened function is documented here:
http://YOUR_DOMAIN/api/documentation

## Contributing

This code has been developped by :
- Ludovic Delhomme from [Datayama](https://datayama.fr). Contact : ludovic.delhomme@datayama.fr

