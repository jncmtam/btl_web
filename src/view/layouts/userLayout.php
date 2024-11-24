<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Company website homepage">
    <meta name="keywords" content="company, services, products, pricing, contact">
    <title>
        <?php echo $this->title ?>
    </title>
    <link rel="stylesheet" href="<?php echo Application::$protocol . "://" . Application::$server_name . "/css/styles.css" ?>">
    <?php foreach ($this->styleSheets as $href ){
        echo '<link rel="stylesheet" href="'.$href.'">';
    } ?>
</head>
<body>
    {{header}}

    {{content}}

    {{footer}}

    <?php foreach ($this->scripts as $src ) {
        echo '<script src="'.$src.'"></script>';   
    } ?>
</body>
</html>