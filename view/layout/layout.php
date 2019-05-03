<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="view/resources/styles/datatables.css">
    <link rel="stylesheet" href="view/resources/styles/datepicker.css">
    <link rel="stylesheet" href="view/resources/styles/slimselect.css">
    <link rel="stylesheet" href="view/resources/styles/tagsinput.css">
    <link rel="stylesheet" href="view/resources/styles/master.css">
    <script src="view/resources/js/moment.js" defer></script>
    <script src="view/resources/js/slimselect.js" defer></script>
    <script src="view/resources/js/tagsinput.js" defer></script>
    <script src="view/resources/js/chart.js" defer></script>
    <script src="view/resources/js/datatables.js" defer></script>
    <script src="view/resources/js/datepicker.js" defer></script>
    <script src="view/resources/js/master.js" defer></script>
    <script src="view/resources/js/jspdf.js" defer></script>
</head>
<body>
    <?php 
        require_once 'header.php'
    ?>
    <section class="content">
        <div class="container">
            <?php echo $content ?>
        </div>
    </section>
    <div class="loader">
        <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
            <circle class="circle" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30">
            </circle>
        </svg>
    </div>
</body>
</html>