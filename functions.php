<?php
function getArrayFromCSV($filename)
{
    $lines = file($filename);
    $titles = str_getcsv($lines[0]);
    array_shift($lines);
    $data = [];
    foreach ($lines as $line) {
        $dataString = str_getcsv($line);
        foreach ($titles as $key => $title) {
            $dataString[$title] = $dataString[$key];
            unset($dataString[$key]);
        }
        $data[] = $dataString;
    }
    return $data;
}

/*$arrayFromCSV = getArrayFromCSV('./data/cities.csv');
$locations = [];
foreach($arrayFromCSV as $key => $values) {
    foreach ($values as $k => $v) {
        $locations[$k] = $v;
    }
    $locations['id'] = $key++;
}*/
echo '';


