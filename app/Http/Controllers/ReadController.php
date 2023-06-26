<?php

namespace App\Http\Controllers;
//require_once('classes/PHPExcel.php');

use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function read(){
        $inputFileType = 'Xlsx';
        $inputFileName = '/home/c/cl17754/updvru/public_html/public/excel/pt3.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $spreadsheet = $reader->load($inputFileName);

        $floorIDs = [];

        if (file_exists($inputFileName)) {
            for($i = 2; $i < 24; $i++) {
                $floor = new \App\Flat();
                $floor->name = $spreadsheet->getActiveSheet()->getCell('B'.$i)->getValue();
                $floor->floor_id = intval($spreadsheet->getActiveSheet()->getCell("C".$i)->getValue());
                $floor->rooms = intval($spreadsheet->getActiveSheet()->getCell("D".$i)->getValue());
                $floor->area = doubleval($spreadsheet->getActiveSheet()->getCell("E".$i)->getValue());
                $floor->uid = $spreadsheet->getActiveSheet()->getCell("F".$i)->getValue();
                $floor->status_id = intval($spreadsheet->getActiveSheet()->getCell("G".$i)->getValue());
                $floor->coordinates = $spreadsheet->getActiveSheet()->getCell("I".$i)->getValue();
                $floor->coast = 1;
                $floor->save();
//                dd($floor);
//                die();
                $floorIDs[] = $floor->id;
            }

            dd($floorIDs);
        }
    }
}
