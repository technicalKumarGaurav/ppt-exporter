<?php

require __DIR__ . '/../vendor/autoload.php';

use Technicalkumargaurav\PptExporter\PptExporter;

PptExporter::make()
    ->title('Employee Report')
    ->save(__DIR__ . '/title.pptx');

echo "Done";