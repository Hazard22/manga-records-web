
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <?php require_once '../config/config.php'; ?>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/favicon/favicon.svg" />
    <link rel="shortcut icon" href="<?= BASE_URL ?>/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= BASE_URL ?>/favicon/apple-touch-icon.png" />
    <link rel="manifest" href="<?= BASE_URL ?>/favicon/site.webmanifest" />
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/css/loader.css">
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://kit.fontawesome.com/c5be75db3a.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <title>Manga Management</title>
</head>
<body class="flex flex-col bg-[#17153B] h-screen justify-beetween">

    <!--Aqui debe ir el header -->
    <?php include_once 'header.php';?>

    <main class="container mx-auto mt-20 mb-auto">
        <?php echo $content; ?>
    </main>

    <!--Aqui debe ir el footer -->
    <?php include_once 'footer.php';?>

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('headerTitle', {
            title: 'Manga Management',
        })

        Alpine.store('headerBgColor', {
            title: null,
        })
    })
</script>

</body>
</html>
