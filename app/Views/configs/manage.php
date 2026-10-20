<?= view('partial/header') ?>

<?php if (ENVIRONMENT == 'development' || get_cookie('debug') == 'true' || request()->getGet('debug') == 'true') : ?>
    <!-- inject:config:debug:js -->
        <script src="resources/js/clipboard-908af414ab.js"></script>
        <!-- endinject -->
<?php else : ?>
    <!-- inject:config:prod:js -->
        <script src="resources/clipboard-15f52a1ee5.min.js"></script>
        <!-- endinject -->
<?php endif; ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<ul class="nav nav-tabs" data-tabs="tabs">
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link active" href="#info_tab" title="<?= lang('Config.info_configuration') ?>"><?= lang('Config.info') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#general_tab" title="<?= lang('Config.general_configuration') ?>"><?= lang('Config.general') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#tax_tab" title="<?= lang('Config.tax_configuration') ?>"><?= lang('Config.tax') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#locale_tab" title="<?= lang('Config.locale_configuration') ?>"><?= lang('Config.locale') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#barcode_tab" title="<?= lang('Config.barcode_configuration') ?>"><?= lang('Config.barcode') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#stock_tab" title="<?= lang('Config.location_configuration') ?>"><?= lang('Config.location') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#receipt_tab" title="<?= lang('Config.receipt_configuration') ?>"><?= lang('Config.receipt') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#invoice_tab" title="<?= lang('Config.invoice_configuration') ?>"><?= lang('Config.invoice') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#shortcuts_tab" title="<?= lang('Config.shortcuts_configuration') ?>"><?= lang('Config.shortcuts') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#reward_tab" title="<?= lang('Config.reward_configuration') ?>"><?= lang('Config.reward') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#table_tab" title="<?= lang('Config.table_configuration') ?>"><?= lang('Config.table') ?></a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#system_tab" title="<?= lang('Config.system_conf') ?>"><?= lang('Config.system_conf') ?></a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="info_tab">
        <?= view('configs/info_config') ?>
    </div>
    <div class="tab-pane" id="general_tab">
        <?= view('configs/general_config') ?>
    </div>
    <div class="tab-pane" id="tax_tab">
        <?= view('configs/tax_config') ?>
    </div>
    <div class="tab-pane" id="locale_tab">
        <?= view('configs/locale_config') ?>
    </div>
    <div class="tab-pane" id="barcode_tab">
        <?= view('configs/barcode_config') ?>
    </div>
    <div class="tab-pane" id="stock_tab">
        <?= view('configs/stock_config') ?>
    </div>
    <div class="tab-pane" id="receipt_tab">
        <?= view('configs/receipt_config') ?>
    </div>
    <div class="tab-pane" id="invoice_tab">
        <?= view('configs/invoice_config') ?>
    </div>
    <div class="tab-pane" id="shortcuts_tab">
        <?= view('configs/shortcuts_config') ?>
    </div>
    <div class="tab-pane" id="reward_tab">
        <?= view('configs/reward_config') ?>
    </div>
    <div class="tab-pane" id="table_tab">
        <?= view('configs/table_config') ?>
    </div>
    <div class="tab-pane" id="system_tab">
        <?= view('configs/system_config') ?>
    </div>
</div>

<?= view('partial/footer') ?>
