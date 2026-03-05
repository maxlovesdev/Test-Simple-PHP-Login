<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'MyApp') ?></title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
        .font-family-karla { font-family: karla; }
    </style>
</head>
<body class="<?= $bodyClass ?? 'bg-gray-100' ?> font-family-karla min-h-screen">
<?php if (!empty($showNav)): ?>
<nav class="bg-black text-white px-8 py-4 flex justify-between items-center">
    <a href="<?= BASE ?>/members/" class="font-bold text-xl">MyApp</a>
    <div class="flex items-center space-x-4">
        <span class="text-gray-300">Logged in as <strong><?= htmlspecialchars($_COOKIE['ID_your_site'] ?? '') ?></strong></span>
        <a href="<?= BASE ?>/logout/" class="bg-white text-black font-semibold px-4 py-2 hover:bg-gray-200">Logout</a>
    </div>
</nav>
<?php endif; ?>