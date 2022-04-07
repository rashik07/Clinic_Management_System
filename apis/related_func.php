<?php

function if_empty($var)
{
    if (isset($var)) {
        if (empty($var)) {
            return "";
        } else {
            return $var;
        }
    }
    else{
        return "";
    }
}
function if_emptyNull($var)
{
    if (isset($var)) {
        if (empty($var)) {
            return "NULL";
        } else {
            return "'".$var."'";
        }
    }
    else{
        return "NULL";
    }
}
function if_empty0($var)
{
    if (isset($var)) {
        if (empty($var)) {
            return 0;
        } else {
            return $var;
        }
    }
    else{
        return 0;
    }
}
function if_empty_datetime($var)
{
    $format = 'Y-m-d H:i:s';
    if (isset($var)) {
        if (empty($var)) {
            return 'NULL';
        } else {
            return $var;
        }
    }
    else{
        return 'NULL';
    }

}