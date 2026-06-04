<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SurDev</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >
    <link 
        rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >

    <link rel="stylesheet" href="/surdev/assets/css/style.css">

    <?php if(basename($_SERVER['PHP_SELF']) == 'equipment_detail.php'): ?>
    <link rel="stylesheet" href="/surdev/assets/css/equipment-detail.css">
    <?php endif; ?>
</head>

<body>