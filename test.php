<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// This variable doesn't exist → will throw a notice
echo $undefinedVar;

// Call a missing function → will throw a fatal error
missing_function_call();
?>
