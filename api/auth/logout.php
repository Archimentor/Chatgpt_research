<?php
require_once __DIR__.'/../common/init.php';
session_destroy();
api_json(['result'=>'logout']);
