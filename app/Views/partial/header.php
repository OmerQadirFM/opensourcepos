<?php
/**
 * @var object          $user_info
 * @var array           $allowed_modules
 * @var IncomingRequest $request
 * @var array           $config
 */

use CodeIgniter\HTTP\IncomingRequest;
use Config\Services;

$request = Services::request();
?>

<!doctype html>
<html lang="<?= esc(current_language_code(), 'attr') ?>" dir="<?= currentLanguageDirection() ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= base_url() ?>">
    <title><?= esc($config['company']) . ' | ' . lang('Common.powered_by') . ' OSPOS ' . esc(config('App')->application_version) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <?php $theme = in_array($config['theme'] ?? '', ['', 'paper', 'readable'], true) ? 'flatly' : $config['theme']; ?>
    <link rel="stylesheet" href="resources/bootswatch/<?= esc($theme, 'attr') ?>/bootstrap<?= currentLanguageDirection() === 'rtl' ? '.rtl' : '' ?>.min.css">

    <?php if (ENVIRONMENT === 'development' || get_cookie('debug') === 'true' || $request->getGet('debug') === 'true') : ?>
        <!-- inject:debug:css -->
        <link rel="stylesheet" href="resources/css/bootstrap-icons-29825048a4.min.css">
        <link rel="stylesheet" href="resources/css/jquery-ui-7822dc56f5.min.css">
        <link rel="stylesheet" href="resources/css/bootstrap-table-b0f4da9985.min.css">
        <link rel="stylesheet" href="resources/css/bootstrap-table-sticky-header-484e0c607e.min.css">
        <link rel="stylesheet" href="resources/css/daterangepicker-55e1d56082.css">
        <link rel="stylesheet" href="resources/css/flatpickr-d5a8fe5612.min.css">
        <link rel="stylesheet" href="resources/css/tom-select-7852736efc.bootstrap5.min.css">
        <link rel="stylesheet" href="resources/css/chartist-79591c2bf4.min.css">
        <link rel="stylesheet" href="resources/css/chartist-plugin-tooltip-2e0ec92e60.css">
        <link rel="stylesheet" href="resources/css/bootstrap-65ba418a9c.autocomplete.css">
        <link rel="stylesheet" href="resources/css/invoice-98e81bb01f.css">
        <link rel="stylesheet" href="resources/css/ospos_print-f48868b7a8.css">
        <link rel="stylesheet" href="resources/css/ospos-5052a878f5.css">
        <link rel="stylesheet" href="resources/css/popupbox-f17aee0498.css">
        <link rel="stylesheet" href="resources/css/receipt-a207b74db6.css">
        <link rel="stylesheet" href="resources/css/register-10ca20a113.css">
        <link rel="stylesheet" href="resources/css/reports-ace7faf688.css">
        <!-- endinject -->
        <!-- inject:debug:js -->
        <script src="resources/js/jquery-12e87d2f3a.js"></script>
        <script src="resources/js/jquery-4fa896f615.form.js"></script>
        <script src="resources/js/jquery-a0350e8820.validate.js"></script>
        <script src="resources/js/jquery-ui-cbc65ff85e.js"></script>
        <script src="resources/js/bootstrap-7d2c412531.bundle.js"></script>
        <script src="resources/js/bootstrap-table-bdb06552ea.js"></script>
        <script src="resources/js/bootstrap-table-export-6389dc2aa5.js"></script>
        <script src="resources/js/bootstrap-table-mobile-fc655b68ab.js"></script>
        <script src="resources/js/bootstrap-table-sticky-header-cb4d83d172.js"></script>
        <script src="resources/js/moment-ad3346f890.min.js"></script>
        <script src="resources/js/daterangepicker-8a5205cec2.js"></script>
        <script src="resources/js/es6-promise-855125e6f5.js"></script>
        <script src="resources/js/FileSaver-e73b1946e8.js"></script>
        <script src="resources/js/html2canvas-e1d3a8d7cd.js"></script>
        <script src="resources/js/jspdf-bbbebb610c.umd.js"></script>
        <script src="resources/js/purify-d54e267e45.js"></script>
        <script src="resources/js/jspdf-92d87e47e8.plugin.autotable.js"></script>
        <script src="resources/js/xlsx-6b3130af1c.full.min.js"></script>
        <script src="resources/js/tableExport-3d506dfa61.min.js"></script>
        <script src="resources/js/chartist-8a7ecb4445.js"></script>
        <script src="resources/js/chartist-plugin-pointlabels-0a1ab6aa4e.js"></script>
        <script src="resources/js/chartist-plugin-tooltip-116cb48831.js"></script>
        <script src="resources/js/chartist-plugin-axistitle-80a1198058.js"></script>
        <script src="resources/js/chartist-plugin-barlabels-4165273742.js"></script>
        <script src="resources/js/imgpreview-1db063409f.full.jquery.js"></script>
        <script src="resources/js/flatpickr-19f49a9a16.min.js"></script>
        <script src="resources/js/tom-select-f3e2259c05.complete.min.js"></script>
        <script src="resources/js/ui-77842186a7.js"></script>
        <script src="resources/js/manage_tables-d24923f94a.js"></script>
        <script src="resources/js/nominatim-d187095956.autocomplete.js"></script>
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <link rel="stylesheet" href="resources/opensourcepos-44e55c2d09.min.css">
        <!-- endinject -->

        <!-- Tweaks to the UI for a particular theme should drop here  -->
        <?php if ($config['theme'] !== 'flatly' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/css/' . esc($config['theme']) . '.css')) { ?>
            <link rel="stylesheet" href="<?= 'css/' . esc($config['theme']) . '.css' ?>">
        <?php } ?>
        <!-- inject:prod:js -->
        <script src="resources/jquery-2c872dbe60.min.js"></script>
        <script src="resources/opensourcepos-3180b629ac.min.js"></script>
        <!-- endinject -->
    <?php endif; ?>

    <?= view('partial/header_js') ?>
    <?= view('partial/lang_lines') ?>

    <style>
        html {
            overflow: auto;
        }
    </style>
    <link rel="stylesheet" href="css/rtl-fonts.css">
</head>

<body>
    <div class="wrapper">
        <div class="topbar">
            <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div id="liveclock"><?= date($config['dateformat'] . ' ' . $config['timeformat']) ?></div>
                <strong><?= esc($config['company']) ?></strong>
                <div>
                    <?= anchor("home/changePassword/{$user_info->person_id}", "{$user_info->first_name} {$user_info->last_name}", ['class' => 'modal-dlg', 'data-btn-submit' => lang('Common.submit'), 'title' => lang('Employees.change_password')]) ?>
                    <span class="mx-1">|</span>
                    <?= anchor('home/logout', lang('Login.logout')) ?>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-xl bg-primary mb-3" data-bs-theme="dark">
            <div class="container">
                <a class="navbar-brand" href="<?= site_url() ?>">OSPOS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#module-navigation" aria-controls="module-navigation" aria-expanded="false" aria-label="<?= esc(lang('Module.home'), 'attr') ?>">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="module-navigation">
                    <ul class="navbar-nav ms-auto flex-wrap">
                        <?php foreach ($allowed_modules as $module): ?>
                            <?php $isActive = $module->module_id === $request->getUri()->getSegment(1); ?>
                            <li class="nav-item">
                                <a class="nav-link menu-icon<?= $isActive ? ' active' : '' ?>" href="<?= base_url($module->module_id) ?>" title="<?= esc(lang('Module.' . $module->module_id), 'attr') ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                                    <img src="<?= base_url("images/menubar/{$module->module_id}.svg") ?>" alt="" aria-hidden="true"><br>
                                    <?= lang('Module.' . $module->module_id) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="container">
            <div class="ospos-content">
