<?php 
    $url = "http://localhost/rede_social/public/"; 
    
    if(empty($title)) {
        $title = "Rede Social";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <link rel="stylesheet" href="<?= $url."assets/styles/style.css" ?>">
    <script src="<?= $url."assets/scripts/header_navbar.js" ?>" defer></script>
</head>
<body>