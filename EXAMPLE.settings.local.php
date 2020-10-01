<?php

/**
 * NOTE - make a copy of EXAMPLE.settings.local.php without EXAMPLE. in the name
 * (so you should have a file like this called:  settings.local.php)
 * the example verison contents might work, but you might need to tweak things,
 * like adding IP or domain name to trusted_host_patterns if you want to request 
 * to this Drupal instance as anything other than localhost or 127.0.0.1
 */

$databases = [
  'default' =>
  [
    'default' =>
    [
      'database' => 'PROJECT',
      'username' => 'drupal',
      'password' => 'drupal',
      'host' => 'mysql',
      'port' => '3306',
      'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
      'driver' => 'mysql',
      'prefix' => '',
    ],
  ],
];

$settings['hash_salt'] = 'CHANGE_THIS';

$settings['file_public_path'] = 'sites/default/files';

$settings['trusted_host_patterns'] = array(
  '^127\.0\.0\.1$',
  '^localhost$'
);

$settings['update_free_access'] = TRUE;