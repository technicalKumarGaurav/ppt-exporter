<?php

require __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;

$ppt = new PhpPresentation();

$slide = $ppt->getActiveSlide();

$shape = $slide->createRichTextShape()
    ->setHeight(100)
    ->setWidth(600)
    ->setOffsetX(100)
    ->setOffsetY(100);

$shape->createTextRun('Hello PPT Exporter');

$writer = IOFactory::createWriter($ppt, 'PowerPoint2007');
$writer->save(__DIR__ . '/hello.pptx');

echo "PPT generated successfully!";