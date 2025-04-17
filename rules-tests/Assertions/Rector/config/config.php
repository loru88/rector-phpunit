<?php

use Rector\Config\RectorConfig;
use Rector\PHPUnit\Assertions\MigrateToWebmozartsAssert;

return RectorConfig::configure()
    ->withImportNames(removeUnusedImports: true)
    ->withRules([
        MigrateToWebmozartsAssert::class
    ]);
