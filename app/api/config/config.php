<?php

Config::set('default_controller', 'user');
Config::set('default_action', 'index');
Config::set('start_url', substr($_SERVER['REQUEST_URI'], strlen('/api/')));
