<?php

require __DIR__ . '/../vendor/autoload.php';

use Technicalkumargaurav\PptExporter\PptExporter;

$data = [
    ['Name', 'Age', 'City'],
];

for ($i = 1; $i <= 55; $i++) {
    $data[] = [
        'Employee ' . $i,
        rand(20, 50),
        'City ' . $i
    ];
}

PptExporter::make()
    ->title('Employee Report')
    ->rowsPerSlide(20)
    ->table($data)
    ->save(__DIR__ . '/employees.pptx');

echo "PPT generated successfully!";