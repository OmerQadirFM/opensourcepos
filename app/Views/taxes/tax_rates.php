<?php
/**
 * @var string $controller_name
 * @var string $tax_rate_table_headers
 * @var array $config
 */
?>

<script type="text/javascript">
    $(document).ready(function() {
        <?= view('partial/bootstrap_tables_locale') ?>
        table_support.init({
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $tax_rate_table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'tax_rate_id'
        });
    });
</script>

<div id="title_bar" class="btn-toolbar">
    <button class="btn btn-info btn-sm float-end modal-dlg" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= esc("$controller_name/view") ?>" title="<?= lang(ucfirst($controller_name) . ".new") ?>">
        <span class="bi bi-currency-dollar">&nbsp;</span><?= lang(ucfirst($controller_name) . ".new") ?>
    </button>
</div>

<div id="toolbar">
    <div class="float-start btn-toolbar">
        <button id="delete" class="btn btn-secondary btn-sm">
            <span class="bi bi-trash">&nbsp;</span><?= lang('Common.delete') ?>
        </button>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>
