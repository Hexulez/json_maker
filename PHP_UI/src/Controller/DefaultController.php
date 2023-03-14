<?php

namespace App\Controller;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    public function index(Request $request): Response
    {
        $data = [];

        if ($request->files->get('input-file')) {
            $inputFileName = $request->files->get('input-file')->getPathname();
            $outputFileName = __DIR__ . '/../../public/data/output.json';

            $inputFileType = IOFactory::identify($inputFileName);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($inputFileName);
            $worksheet = $spreadsheet->getActiveSheet();

            foreach ($worksheet->getRowIterator(2) as $row) {
                $rowData = [];
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);
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

            return $this->render('default/index.html.twig', [
                'message' => 'JSON file has been created successfully! <a href="/data/output.json" download>Download JSON file</a>'
            ]);
        }

        return $this->render('default/index.html.twig');
    }
      public function upload(): Response
    {
        return $this->render('default/upload.html.twig');
    }
}
