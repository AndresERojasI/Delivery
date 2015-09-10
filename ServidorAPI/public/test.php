<?php

// you can use print for debugging purposes, e.g.
// print "this is a debug message\n";

function solution($A)
{
    //let's validate the integrity of the input parameter
    if (isset($A) && !empty($A) && is_array($A) && count($A) <= 100000) {
        $equilibrium_indexes = array();
        //Let's iterate through the array
        foreach ($A as $key => $value) {
            if ($key !== 0) {
                //0 <= P <= N
                $_a = array_slice($A, 0, $key);
                $_b = array_slice($A, (($key) - (count($A) - 1)));
                if (count($_a) > 0 && count($_b) > 0) {
                    if (array_sum($_a) === array_sum($_b)) {
                        $equilibrium_indexes[] = $key;
                    }
                }
            }
        }

        if (count($equilibrium_indexes) > 0) {
            return $equilibrium_indexes;
        } else {
            return -1;
        }
    } else {
        return false;
    }
}
try {
    var_dump(solution([-1, 3, -4, 5, 1, -6, 2, 1]));
} catch (Exception $e) {
    var_dump($e);
}

function generarArray($tamanio, $min, $max)
{
    $arreglo;
    for ($i = 0; $i < $tamanio; ++$i) {
        $arreglo[] = rand($min, $max);
    }

    echo json_encode($arreglo);
}

//generarArray(100000, 0, 1);

echo 1 % 2;
