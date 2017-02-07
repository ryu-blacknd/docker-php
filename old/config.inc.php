<?php
$i = 0;

$i++;
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['auth_type'] = 'config';
$cfg['Servers'][$i]['user'] = 'root';
$cfg['Servers'][$i]['password'] = 'password';

$cfg['Servers'][$i]['AllowRoot'] = true;
$cfg['Servers'][$i]['hide_db'] = "(^information_schema$|^performance_schema$|^mysql$)";
