<?php

require_once('../init/autoload.php');
require_once('../config/config.php');
//phpinfo();
App::run(Config::get('start_url'));