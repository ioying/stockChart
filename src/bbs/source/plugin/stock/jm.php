<?php
preg_match_all("/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i",
        $comm_test, $newstr6);
?>