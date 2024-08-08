<?php

$phpkg_import_file = getenv('PHPKG_IMPORT_FILE');
require_once "$phpkg_import_file";
require_once __DIR__ . '/Source/Assertions.php';
require_once __DIR__ . '/Source/Document.php';
require_once __DIR__ . '/Source/TestRun.php';
require_once __DIR__ . '/Source/Runner.php';
