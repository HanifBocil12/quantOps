<?php
require 'vendor/autoload.php';

use danog\MadelineProto\API;

$settings = new \danog\MadelineProto\Settings\AppInfo();
$settings->setApiId((int) getenv('TELEGRAM_API_ID') ?: 30176333);
$settings->setApiHash(getenv('TELEGRAM_API_HASH') ?: '84cb991c0806088eb80ea2e8fe5722aa');

$MadelineProto = new API('session.madeline', $settings);
$MadelineProto->start();

echo "Login berhasil! Session tersimpan di session.madeline\n";