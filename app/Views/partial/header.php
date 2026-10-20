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
        <!-- endinject -->
        <!-- inject:debug:js -->
        <!-- endinject -->
    <?php else : ?>
        <!--inject:prod:css -->
        <!-- endinject -->

        <!-- Tweaks to the UI for a particular theme should drop here  -->
        <?php if ($config['theme'] !== 'flatly' && file_exists($_SERVER['DOCUMENT_ROOT'] . '/public/css/' . esc($config['theme']) . '.css')) { ?>
            <link rel="stylesheet" href="<?= 'css/' . esc($config['theme']) . '.css' ?>">
        <?php } ?>
        <!-- inject:prod:js -->
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
