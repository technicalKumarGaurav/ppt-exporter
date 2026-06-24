# PPT Exporter

A lightweight PHP library to export tabular data into PowerPoint presentations.

## Features

- Export arrays to PowerPoint (.pptx)
- Add presentation title
- Generate editable PowerPoint tables
- Split large datasets across multiple slides
- PSR-4 compliant
- Built on PHPPresentation

## Installation

```bash
composer require technicalkumargaurav/ppt-exporter
```

## Usage

```php
<?php

require 'vendor/autoload.php';

use Technicalkumargaurav\PptExporter\PptExporter;

$data = [
    ['Name', 'Age', 'City'],
    ['Gaurav', 30, 'Bhopal'],
    ['Rahul', 25, 'Delhi'],
];

PptExporter::make()
    ->title('Employee Report')
    ->table($data)
    ->save('employees.pptx');
```

## Multi Slide Example

```php
<?php

require 'vendor/autoload.php';

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
    ->save('employees.pptx');
```

## Output

- Slide 1: Title + Rows 1-20
- Slide 2: Title + Rows 21-40
- Slide 3: Title + Remaining Rows

## Requirements

- PHP 8.1+
- PHPPresentation 1.2+

## Roadmap

- Header styling
- Auto column width
- Excel to PPT export
- Multiple tables per presentation
- Charts support

## License

MIT License
