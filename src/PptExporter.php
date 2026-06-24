<?php

namespace Technicalkumargaurav\PptExporter;

use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Fill;

class PptExporter
{
    protected PhpPresentation $presentation;
    protected $currentSlide;

    protected int $rowsPerSlide = 20;
    protected array $tableData = [];
    protected ?string $titleText = null;

    public function __construct()
    {
        $this->presentation = new PhpPresentation();
        $this->currentSlide = $this->presentation->getActiveSlide();
    }

    public static function make(): self
    {
        return new self();
    }

    public function addSlide(): self
    {
        $this->currentSlide = $this->presentation->createSlide();

        return $this;
    }

    public function title(string $title): self
    {
        $this->titleText = $title;

        return $this;
    }

    public function table(array $data): self
    {
        $this->tableData = $data;

        return $this;
    }

    public function rowsPerSlide(int $rows): self
    {
        $this->rowsPerSlide = max(1, $rows);

        return $this;
    }

    protected function renderTitle(): void
    {
        if (!$this->titleText) {
            return;
        }

        $shape = $this->currentSlide->createRichTextShape()
            ->setHeight(40)
            ->setWidth(700)
            ->setOffsetX(30)
            ->setOffsetY(15);

        $shape->createTextRun($this->titleText);
    }

    protected function renderTable(): void
    {
        if (empty($this->tableData)) {
            return;
        }

        $header = $this->tableData[0];
        $rows = array_slice($this->tableData, 1);

        $chunks = array_chunk($rows, $this->rowsPerSlide);

        foreach ($chunks as $index => $chunk) {

            if ($index === 0) {
                $this->currentSlide = $this->presentation->getActiveSlide();
            } else {
                $this->currentSlide = $this->presentation->createSlide();
            }

            // Render title on every slide
            $this->renderTitle();

            $tableData = array_merge([$header], $chunk);

            $table = $this->currentSlide->createTableShape(count($header));

            $table->setWidth(700)
                ->setOffsetX(30)
                ->setOffsetY(70);

            foreach ($tableData as $rowIndex => $rowData) {

                $row = $table->createRow();

                foreach ($rowData as $cellValue) {

                    $cell = $row->nextCell();

                    $textRun = $cell->createTextRun((string) $cellValue);

                    // Header row styling
                    if ($rowIndex === 0) {

                        $textRun->getFont()
                            ->setBold(true)
                            ->setColor(new \PhpOffice\PhpPresentation\Style\Color('FFFFFF'));

                        $cell->getFill()
                            ->setFillType(\PhpOffice\PhpPresentation\Style\Fill::FILL_SOLID)
                            ->setStartColor(new \PhpOffice\PhpPresentation\Style\Color('4472C4'));
                    }
                }
            }
        }
    }

    public function save(string $path): void
    {
        $this->renderTable();

        $writer = IOFactory::createWriter(
            $this->presentation,
            'PowerPoint2007'
        );

        $writer->save($path);
    }
}
