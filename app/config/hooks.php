<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

// Check db connection for installation 
$hook['post_controller_constructor'] = array(
        'class'    => 'Sma_hooks',
        'function' => 'check',
        'filename' => 'Sma_hooks.php',
        'filepath' => 'hooks'
);

// Customer Change As Students
 $hook['display_override'] = array(
     'class' => 'Sma_hooks',
     'function' => 'customers_as_students',
     'filename' => 'Sma_hooks.php',
     'filepath' => 'hooks'
 );
// Customer Change for https://ponnusamy.simplypos.in
 $hook['display_override'] = array(
     'class' => 'Sma_hooks',
     'function' => 'custom_labels_for_ponnusamy',
     'filename' => 'Sma_hooks.php',
     'filepath' => 'hooks'
 );
  



// Compress output
// $hook['display_override'] = array(
//     'class' => 'Sma_hooks',
//     'function' => 'minify',
//     'filename' => 'Sma_hooks.php',
//     'filepath' => 'hooks'
// );
