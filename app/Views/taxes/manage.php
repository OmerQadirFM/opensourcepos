<?php
/**
 * @var string $controller_name
 */
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    dialog_support.init("a.modal-dlg");
</script>

<ul class="nav nav-tabs" data-tabs="tabs">
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link active" href="#tax_codes_tab" title="<?= lang(ucfirst($controller_name) . '.tax_codes_configuration') ?>">
            <?= lang(ucfirst($controller_name) . '.tax_codes') ?>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#tax_jurisdictions_tab" title="<?= lang(ucfirst($controller_name) . '.tax_jurisdictions_configuration') ?>">
            <?= lang(ucfirst($controller_name) . '.tax_jurisdictions') ?>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#tax_categories_tab" title="<?= lang(ucfirst($controller_name) . '.tax_categories_configuration') ?>">
            <?= lang(ucfirst($controller_name) . '.tax_categories') ?>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a data-bs-toggle="tab" role="tab" class="nav-link" href="#tax_rates_tab" title="<?= lang(ucfirst($controller_name) . '.tax_rate_configuration') ?>">
            <?= lang(ucfirst($controller_name) . '.tax_rates') ?>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade show active" id="tax_codes_tab">
        <?= view('taxes/tax_codes') ?>
    </div>
    <div class="tab-pane" id="tax_jurisdictions_tab">
        <?= view('taxes/tax_jurisdictions') ?>
    </div>
    <div class="tab-pane" id="tax_categories_tab">
        <?= view('taxes/tax_categories') ?>
    </div>
    <div class="tab-pane" id="tax_rates_tab">
        <?= view('taxes/tax_rates') ?>
    </div>
</div>

<?= view('partial/footer') ?>
