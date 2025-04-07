<!DOCTYPE html>
<html lang="fr" class="transition duration-500">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= PUBLIC_URL ?>css/output.css" rel="stylesheet">
    <link href="<?= PUBLIC_URL ?>css/custom.css" rel="stylesheet">

    <title> <?= htmlspecialchars($title) ?? 'KONGB' ?></title>
</head>

<body class="bg-gray-200 dark:bg-gray-900 text-gray-900 dark:text-white ">

    <button onclick="toggleTheme()"
        class="fixed self-end p-2 dark:text-white bg-white dark:bg-gray-700  rounded-full top-2 md:top-5 right-3 md:right-20 hover:bg-gray-100 dark:hover:bg-gray-700 transition-transform transform hover:scale-110 z-50">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path id="theme-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
        </svg>
    </button>

    <div class="flex h-screen">

        <?php //include __DIR__ . '/../partials/header.php'; ?>
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>

        <div class="flex-1 p-8 overflow-y-auto">

            <?= $content ?>

            <!-- Bouton Retour (conditionnel) -->
            <?php
            $currentRoute = $_SERVER['REQUEST_URI'];

            $hideBackButton = in_array($currentRoute, [
                '/Projets/gestion_pharmacie/public/dashboard',
                '/Projets/gestion_pharmacie/public/customer',
                '/Projets/gestion_pharmacie/public/booking',
            ]);

            if (!$hideBackButton): ?>
                <button onclick="goBack() "
                    class="mb-4 p-2 bg-teal-500 text-white rounded-lg cursor-pointer hover:bg-teal-600">
                    Retour
                </button>
            <?php endif ?>


        </div>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>


    <script src="<?= PUBLIC_URL ?>js/main.js"></script>

</body>

</html>