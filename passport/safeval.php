<?php
require_once('includes/common/KT_common.php');
//SQL Injection protection
if (!function_exists("GetSQLValueString")) {
    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
    {
        $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
        switch ($theType) {
            case "text":
                $theValue =   KT_escapeForSql($theValue,'STRING_TYPE');
                break;
            case "long":
            case "int":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                $theValue =    KT_escapeForSql($theValue,'NUMERIC_TYPE');
                break;
            case "double":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                $theValue =   KT_escapeForSql($theValue,'DOUBLE_TYPE');
                break;
            case "date":
                $theValue =  KT_escapeForSql($theValue,'DATE_TYPE');
                break;
            case "defined":
                $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
                $theValue =  KT_escapeFieldName($theValue);
                break;
        }
        return $theValue;
    }
}


?>