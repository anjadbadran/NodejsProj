<?php
/**
 * Created by PhpStorm.
 * User: Trainer-PC
 * Date: 12/8/2016
 * Time: 11:41 AM
 */
session_start();
$requiredDataNames = ['name', 'email', 'mobile', 'password'];


$collectedData = array();
$errors = array();
foreach ($requiredDataNames as $requiredDataName){
    if(isset($_POST[$requiredDataName]) && !empty($_POST[$requiredDataName])){
        $collectedData[$requiredDataName] = $_POST[$requiredDataName];
    }else{
        $errors[$requiredDataName] = 'Field '.$requiredDataName.' is required';
    }
}

$verifyCallbacks = array(
    'name' => function($value){
        $pattern = '/[a-zA-Z]{3,30}/';
        $valid = (boolean)preg_match($pattern, $value);
        return ($valid)?$value:false;
    },
    'email' => function($value){
        return filter_var($value,FILTER_VALIDATE_EMAIL);
    }
);
foreach ($verifyCallbacks as $name => $function){
    if(array_key_exists($name, $collectedData) &&
        !array_key_exists($name, $errors)
    ){
        $validValue = $function($collectedData[$name]);
        if(!$validValue){
            $errors[$name] = 'Input data '.$name.' is not valid';
        }else{
            $collectedData[$name] = $validValue;
        }
    }
}

if(count($errors) > 0){
    $_SESSION['do-register'] = array(
        'data' => $_POST,
        'errors' => $errors
    );
    header('location: /register.php');
    exit();
}

// do save data




// successful save
unset($_SESSION['do-register']);
header('location:/login.php');

