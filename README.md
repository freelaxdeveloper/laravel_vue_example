# DonateSupp

## artisan commands
<dl>
  <dt>Create admin profile</dt>
  <dd>

    php artisan AdminCreate
  </dd>

  <dt>Running queues</dt>
  <dd>

    php artisan queue:work
  </dd>

  <dt>Reset Google2fa</dt>
  <dd>

    php artisan AdminGoogleReset
  </dd>

  <dt>Set up file upload</dt>
  <dd>

    sudo chmod 775 ./public/storage/uploads/
    sudo chown www-data:www-data ./public/storage/uploads/
  </dd>

  <dt>Customize Donate Page</dt>
  <dd>

    php artisan db:seed --class=SettingDonateForm
  </dd>

  <dt>Sides</dt>
  <dd>

    php artisan db:seed --class=WidgetsCategory
  </dd>
</dl>


## Site installation
<dl>

  <dt>Settings Apache2 (if used)</dt>
  <dd>

    - enable support .htaccess
    - enable module rewrite (a2enmod rewrite)
    - enable module headers (a2enmod headers)
    - restart the server (service apache2 restart)
  </dd>

  <dt>Install composer</dt>
  <dd>

    composer install
  </dd>

  <dt>Create file .env</dt>
  <dd>

    cp .env.example .env
  </dd>

  <dt>Create key</dt>
  <dd>

    openssl genrsa -out ./storage/keys/private.key 1024
    sudo chmod 775 ./storage/keys/private.key
  </dd>

  <dt>Set up database connection (.env)</dt>
  <dd>

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=
    DB_USERNAME=root
    DB_PASSWORD=
  </dd>

  <dt>Run a list of artisan commands</dt>
  <dd>

    php artisan key:generate
    php artisan jwt:secret
    php artisan migrate
    php artisan FontGenerate
    php artisan storage:link
  </dd>

  <dt>Set permissions</dt>
  <dd>

    sudo chmod -R 777 storage/logs/
    sudo chmod -R 777 storage/framework/sessions/
    sudo chmod -R 777 storage/framework/views/
    sudo chmod -R 777 storage/framework/cache/
    sudo chmod -R 777 public/storage
  </dd>
</dl>

- create a tweak service in services


-------------------

https://github.com/zircote/swagger-php/blob/d191b5fca4f08786605316895f0542938bacb4a8/Examples/petstore.swagger.io/controllers/PetController.php#L65
