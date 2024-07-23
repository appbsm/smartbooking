<?php

define('ENVIRONMENT', 'development'); // เปลี่ยนเป็น 'production' เมื่อใช้งานจริง

if (defined('ENVIRONMENT'))
{
    switch (ENVIRONMENT)
    {
        case 'development':
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            break;

        case 'testing':
        case 'production':
            error_reporting(0);
            ini_set('display_errors', 0);
            break;

        default:
            exit('The application environment is not set correctly.');
    }
}

$system_path = 'system';
$application_folder = 'application';

if (realpath($system_path) !== FALSE)
{
    $system_path = realpath($system_path).'/';
}

$system_path = rtrim($system_path, '/').'/';

if ( ! is_dir($system_path))
{
    exit("Your system folder path does not appear to be set correctly.");
}

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('EXT', '.php');
define('BASEPATH', str_replace("\\", "/", $system_path));
define('FCPATH', str_replace(SELF, '', __FILE__));
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

if (is_dir($application_folder))
{
    define('APPPATH', $application_folder.'/');
}
else
{
    if ( ! is_dir(BASEPATH.$application_folder.'/'))
    {
        exit("Your application folder path does not appear to be set correctly.");
    }

    define('APPPATH', BASEPATH.$application_folder.'/');
}

require_once BASEPATH.'core/CodeIgniter.php';
