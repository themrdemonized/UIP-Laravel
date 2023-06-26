<?php return array (
  'app' =>
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://127.0.0.1:8000',
    'asset_url' => NULL,
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => 'base64:mOYFj1qiP5X/SRNF2U7L+i+GQ28QLVn/hmJTykf8gLY=',
    'cipher' => 'AES-256-CBC',
    'providers' =>
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
      26 => 'Barryvdh\\LaravelIdeHelper\\IdeHelperServiceProvider',
      27 => 'Tymon\\JWTAuth\\Providers\\LaravelServiceProvider',
    ),
    'aliases' =>
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Arr' => 'Illuminate\\Support\\Arr',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'Str' => 'Illuminate\\Support\\Str',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'JWTAuth' => 'Tymon\\JWTAuth\\Facades\\JWTAuth',
    ),
  ),
  'auth' =>
  array (
    'defaults' =>
    array (
      'guard' => 'api',
      'passwords' => 'users',
    ),
    'guards' =>
    array (
      'web' =>
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' =>
      array (
        'driver' => 'jwt',
        'provider' => 'users',
      ),
    ),
    'providers' =>
    array (
      'users' =>
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' =>
    array (
      'users' =>
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
        'throttle' => 60,
      ),
    ),
    'password_timeout' => 10800,
  ),
  'broadcasting' =>
  array (
    'default' => 'log',
    'connections' =>
    array (
      'pusher' =>
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' =>
        array (
          'cluster' => 'mt1',
          'useTLS' => true,
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' =>
      array (
        'driver' => 'log',
      ),
      'null' =>
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' =>
  array (
    'default' => 'file',
    'stores' =>
    array (
      'apc' =>
      array (
        'driver' => 'apc',
      ),
      'array' =>
      array (
        'driver' => 'array',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' =>
      array (
        'driver' => 'file',
        'path' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/framework/cache/data',
      ),
      'memcached' =>
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' =>
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' =>
        array (
        ),
        'servers' =>
        array (
          0 =>
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'cache',
      ),
      'dynamodb' =>
      array (
        'driver' => 'dynamodb',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'table' => 'cache',
        'endpoint' => NULL,
      ),
    ),
    'prefix' => 'laravel_cache',
  ),
  'database' =>
  array (
    'default' => 'mysql',
    'connections' =>
    array (
      'sqlite' =>
      array (
        'driver' => 'sqlite',
        'url' => NULL,
        'database' => 'cl17754_uipn',
        'prefix' => '',
        'foreign_key_constraints' => true,
      ),
      'mysql' =>
      array (
        'driver' => 'mysql',
        'url' => NULL,
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'database' => getenv('DB_DATABASE'),
        'username' => getenv('DB_USERNAME'),
        'password' => getenv('DB_PASSWORD'),
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => NULL,
        'options' =>
        array (
        ),
      ),
      'pgsql' =>
      array (
        'driver' => 'pgsql',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cl17754_uipn',
        'username' => 'cl17754_uipn',
        'password' => 'TZ9i62wT',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' =>
      array (
        'driver' => 'sqlsrv',
        'url' => NULL,
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'cl17754_uipn',
        'username' => 'cl17754_uipn',
        'password' => 'TZ9i62wT',
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
      ),
    ),
    'migrations' => 'migrations',
    'redis' =>
    array (
      'client' => 'phpredis',
      'options' =>
      array (
        'cluster' => 'redis',
        'prefix' => 'laravel_database_',
      ),
      'default' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
      'cache' =>
      array (
        'url' => NULL,
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 1,
      ),
    ),
  ),
  'filesystems' =>
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' =>
    array (
      'local' =>
      array (
        'driver' => 'local',
        'root' => getenv('UPDVRU_WEBSITE_DIR') . '/storage//app',
      ),
      'my_files' =>
      array (
        'driver' => 'local',
        'root' => getenv('UPDVRU_WEBSITE_DIR') . '/public',
      ),
      'public' =>
      array (
        'driver' => 'local',
        'root' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/app/public',
        'url' => 'http://127.0.0.1:8000/storage',
        'visibility' => 'public',
      ),
      's3' =>
      array (
        'driver' => 's3',
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
        'bucket' => '',
        'url' => NULL,
      ),
    ),
  ),
  'hashing' =>
  array (
    'driver' => 'bcrypt',
    'bcrypt' =>
    array (
      'rounds' => 10,
    ),
    'argon' =>
    array (
      'memory' => 1024,
      'threads' => 2,
      'time' => 2,
    ),
  ),
  'ide-helper' =>
  array (
    'filename' => '_ide_helper',
    'format' => 'php',
    'meta_filename' => '.phpstorm.meta.php',
    'include_fluent' => true,
    'include_factory_builders' => false,
    'write_model_magic_where' => true,
    'write_eloquent_model_mixins' => false,
    'include_helpers' => false,
    'helper_files' =>
    array (
      0 => getenv('UPDVRU_WEBSITE_DIR') . '/vendor/laravel/framework/src/Illuminate/Support/helpers.php',
    ),
    'model_locations' =>
    array (
      0 => 'app',
    ),
    'extra' =>
    array (
      'Eloquent' =>
      array (
        0 => 'Illuminate\\Database\\Eloquent\\Builder',
        1 => 'Illuminate\\Database\\Query\\Builder',
      ),
      'Session' =>
      array (
        0 => 'Illuminate\\Session\\Store',
      ),
    ),
    'magic' =>
    array (
    ),
    'interfaces' =>
    array (
    ),
    'custom_db_types' =>
    array (
    ),
    'model_camel_case_properties' => false,
    'type_overrides' =>
    array (
      'integer' => 'int',
      'boolean' => 'bool',
    ),
    'include_class_docblocks' => false,
  ),
  'jwt' =>
  array (
    'secret' => 'j0T4ydgJ2I8Hf3TkJBauzkG7uwV0N35RcymaR4woL9jXmcL4K1Mrm20oK4HUc1vh',
    'keys' =>
    array (
      'public' => NULL,
      'private' => NULL,
      'passphrase' => NULL,
    ),
    'ttl' => 60,
    'refresh_ttl' => 525600,
    'algo' => 'HS256',
    'required_claims' =>
    array (
      0 => 'iss',
      1 => 'iat',
      2 => 'exp',
      3 => 'nbf',
      4 => 'sub',
      5 => 'jti',
    ),
    'persistent_claims' =>
    array (
    ),
    'lock_subject' => true,
    'leeway' => 0,
    'blacklist_enabled' => true,
    'blacklist_grace_period' => 0,
    'decrypt_cookies' => false,
    'providers' =>
    array (
      'jwt' => 'Tymon\\JWTAuth\\Providers\\JWT\\Lcobucci',
      'auth' => 'Tymon\\JWTAuth\\Providers\\Auth\\Illuminate',
      'storage' => 'Tymon\\JWTAuth\\Providers\\Storage\\Illuminate',
    ),
  ),
  'logging' =>
  array (
    'default' => 'stack',
    'channels' =>
    array (
      'stack' =>
      array (
        'driver' => 'stack',
        'channels' =>
        array (
          0 => 'daily',
        ),
        'ignore_exceptions' => false,
      ),
      'single' =>
      array (
        'driver' => 'single',
        'path' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/logs/laravel.log',
        'level' => 'debug',
      ),
      'daily' =>
      array (
        'driver' => 'daily',
        'path' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/logs/laravel.log',
        'level' => 'debug',
        'days' => 14,
      ),
      'slack' =>
      array (
        'driver' => 'slack',
        'url' => NULL,
        'username' => 'Laravel Log',
        'emoji' => ':boom:',
        'level' => 'critical',
      ),
      'papertrail' =>
      array (
        'driver' => 'monolog',
        'level' => 'debug',
        'handler' => 'Monolog\\Handler\\SyslogUdpHandler',
        'handler_with' =>
        array (
          'host' => NULL,
          'port' => NULL,
        ),
      ),
      'stderr' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\StreamHandler',
        'formatter' => NULL,
        'with' =>
        array (
          'stream' => 'php://stderr',
        ),
      ),
      'syslog' =>
      array (
        'driver' => 'syslog',
        'level' => 'debug',
      ),
      'errorlog' =>
      array (
        'driver' => 'errorlog',
        'level' => 'debug',
      ),
      'null' =>
      array (
        'driver' => 'monolog',
        'handler' => 'Monolog\\Handler\\NullHandler',
      ),
    ),
  ),
  'mail' =>
  array (
    'driver' => 'smtp',
    'host' => 'smtp.yandex.ru',
    'port' => '465',
    'from' =>
    array (
      'address' => 'bron@uip-dv.ru',
      'name' => 'УИП',
    ),
    'encryption' => 'ssl',
    'username' => 'bron@uip-dv.ru',
    'password' => 'pass2021tgb$#',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' =>
    array (
      'theme' => 'default',
      'paths' =>
      array (
        0 => getenv('UPDVRU_WEBSITE_DIR') . '/resources/views/vendor/mail',
      ),
    ),
    'log_channel' => NULL,
  ),
  'queue' =>
  array (
    'default' => 'sync',
    'connections' =>
    array (
      'sync' =>
      array (
        'driver' => 'sync',
      ),
      'database' =>
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' =>
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => 0,
      ),
      'sqs' =>
      array (
        'driver' => 'sqs',
        'key' => '',
        'secret' => '',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' =>
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
        'block_for' => NULL,
      ),
    ),
    'failed' =>
    array (
      'driver' => 'database',
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' =>
  array (
    'mailgun' =>
    array (
      'domain' => NULL,
      'secret' => NULL,
      'endpoint' => 'api.mailgun.net',
    ),
    'postmark' =>
    array (
      'token' => NULL,
    ),
    'ses' =>
    array (
      'key' => '',
      'secret' => '',
      'region' => 'us-east-1',
    ),
  ),
  'session' =>
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' =>
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => false,
    'http_only' => true,
    'same_site' => NULL,
  ),
  'view' =>
  array (
    'paths' =>
    array (
      0 => getenv('UPDVRU_WEBSITE_DIR') . '/resources/views',
    ),
    'compiled' => getenv('UPDVRU_WEBSITE_DIR') . '/storage/framework/views',
  ),
  'flare' =>
  array (
    'key' => NULL,
    'reporting' =>
    array (
      'anonymize_ips' => true,
      'collect_git_information' => true,
      'report_queries' => true,
      'maximum_number_of_collected_queries' => 200,
      'report_query_bindings' => true,
      'report_view_data' => true,
      'grouping_type' => NULL,
    ),
    'send_logs_as_events' => true,
  ),
  'ignition' =>
  array (
    'editor' => 'phpstorm',
    'theme' => 'light',
    'enable_share_button' => true,
    'register_commands' => false,
    'ignored_solution_providers' =>
    array (
    ),
    'enable_runnable_solutions' => NULL,
    'remote_sites_path' => '',
    'local_sites_path' => '',
    'housekeeping_endpoint_prefix' => '_ignition',
  ),
  'trustedproxy' =>
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'tinker' =>
  array (
    'commands' =>
    array (
    ),
    'dont_alias' =>
    array (
      0 => 'App\\Nova',
    ),
  ),
);
