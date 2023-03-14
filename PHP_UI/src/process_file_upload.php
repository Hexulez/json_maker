<?php

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_FILES["input-file"]["error"] > 0) {
    echo "Error: " . $_FILES["input-file"]["error"] . "<br>";
} else {
    $inputFileName = $_FILES["input-file"]["tmp_name"];
    $outputFileName = __DIR__ . '/../data/output.json';

    $inputFileType = IOFactory::identify($inputFileName);
    $reader = IOFactory::createReader($inputFileType);
    $spreadsheet = $reader->load($inputFileName);
    $worksheet = $spreadsheet->getActiveSheet();

    $data = [];
    foreach ($worksheet->getRowIterator(2) as $row) {
        $rowData = [];
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE);
        foreach ($cellIterator as $cell) {
            switch ($cell->getColumn()) {
                case 'A':
                    $rowData['Number'] = $cell->getValue();
                    break;
                case 'B':
                    $rowData['Surname'] = $cell->getValue();
                    break;
                case 'C':
                    $rowData['First Name'] = $cell->getValue();
                    break;
                case 'D':
                    $rowData['Captain'] = $cell->getValue();
                    break;
                case 'E':
                    $rowData['Position'] = $cell->getValue();
                    break;
                case 'F':
                    $rowData['Jersey type'] = $cell->getValue();
                    break;
                case 'G':
                    $rowData['Rarity'] = $cell->getValue();
                    break;
                case 'H':
                    $rowData['Collection'] = $cell->getValue();
                    break;
            }
        }
        $data[] = $rowData;
    }

    $output = json_encode($data);
    file_put_contents($outputFileName, $output);

} echo 'JSON file has been created successfully! <a href="../data/output.json" download>Download JSON file</a>';
