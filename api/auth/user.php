<?php
require_once __DIR__.'/../common/init.php';
api_require_login();

api_json(['user'=>api_current_user()]);
