<?php
/**
 * @var string $controller_name
 * @var string $table_headers
 * @var array $filters
 * @var array $stock_locations
 * @var int $stock_location
 * @var array $config
 * @var string|null $start_date
 * @var string|null $end_date
 * @var array $selected_filters
 */

use App\Models\Employee;
?>

<?= view('partial/header') ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#generate_barcodes').click(function() {
            window.open(
                'index.php/items/generateBarcodes/' + table_support.selected_ids().join(':'),
                '_blank'
            );
        });

        $('#filters').on('hidden.bs.select', function(e) {
            table_support.refresh();
        });

        if ($('#stock_location').length) {
            $('#stock_location').on('change', function() {
                table_support.refresh();
            });
        }

        // Load the preset daterange picker
        <?= view('partial/daterangepicker') ?>

        $("#daterangepicker").on('apply.daterangepicker', function(ev, picker) {
            table_support.refresh();
        });

        // Set the beginning of time as starting date
        $('#daterangepicker').data('daterangepicker').setStartDate("<?= date($config['dateformat'], mktime(0, 0, 0, 01, 01, 2010)) ?>");
        // Update the hidden inputs with the selected dates before submitting the search data
        start_date = "<?= date('Y-m-d', mktime(0, 0, 0, 01, 01, 2010)) ?>";

        // Override dates from server if provided
        <?php if (isset($start_date) && $start_date): ?>
        start_date = "<?= esc($start_date) ?>";
        <?php endif; ?>
        <?php if (isset($end_date) && $end_date): ?>
        end_date = "<?= esc($end_date) ?>";
        <?php endif; ?>

        <?php
        echo view('partial/bootstrap_tables_locale');
        $employee = model(Employee::class);
        ?>

        table_support.init({
            employee_id: <?= $employee->get_logged_in_employee_info()->person_id ?>,
            resource: '<?= esc($controller_name) ?>',
            headers: <?= $table_headers ?>,
            pageSize: <?= $config['lines_per_page'] ?>,
            uniqueId: 'items.item_id',
            queryParams: function() {
                return $.extend(arguments[0], {
                    "start_date": start_date,
                    "end_date": end_date,
                    "stock_location": $("#stock_location").val(),
                    "filters": $("#filters").val()
                });
            },
            onLoadSuccess: function(response) {
                $('a.rollover').imgPreview({
                    imgCSS: {
                        width: 200
                    },
                    distanceFromCursor: {
                        top: 10,
                        left: -210
                    }
                })
            }
        });
    });
</script>

<?= view('partial/table_filter_persistence', ['additional_params' => ['stock_location']]) ?>

<div id="title_bar" class="btn-toolbar print_hide">
    <button class="btn btn-info btn-sm float-end modal-dlg" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/csvImport" ?>" title="<?= lang('Items.import_items_csv') ?>">
        <span class="bi bi-upload">&nbsp;</span><?= lang('Common.import_csv') ?>
    </button>

    <button class="btn btn-info btn-sm float-end modal-dlg" data-btn-new="<?= lang('Common.new') ?>" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "$controller_name/view" ?>" title="<?= lang(ucfirst($controller_name) . '.new') ?>">
        <span class="bi bi-tag">&nbsp;</span><?= lang(ucfirst($controller_name) . '.new') ?>
    </button>
</div>

<div id="toolbar">
    <div class="float-start d-flex flex-wrap align-items-center gap-2" role="toolbar">
        <button id="delete" class="btn btn-secondary btn-sm print_hide">
            <span class="bi bi-trash">&nbsp;</span><?= lang('Common.delete') ?>
        </button>
        <button id="bulk_edit" class="btn btn-secondary btn-sm modal-dlg print_hide" data-btn-submit="<?= lang('Common.submit') ?>" data-href="<?= "items/bulkEdit" ?>" title="<?= lang('Items.edit_multiple_items') ?>">
            <span class="bi bi-pencil-square">&nbsp;</span><?= lang('Items.bulk_edit') ?>
        </button>
        <button id="generate_barcodes" class="btn btn-secondary btn-sm print_hide" data-href="<?= "$controller_name/generateBarcodes" ?>" title="<?= lang('Items.generate_barcodes') ?>">
            <span class="bi bi-upc">&nbsp;</span><?= lang('Items.generate_barcodes') ?>
        </button>
        <?= form_input(['name' => 'daterangepicker', 'class' => 'form-control form-control-sm', 'id' => 'daterangepicker']) ?>
        <?= form_multiselect('filters[]', $filters, $selected_filters ?? [], [
            'id'                        => 'filters',
            'class'                     => 'search-select ',
            'data-placeholder'   => lang('Common.none_selected_text'),
]) ?>
        <?php
        if (count($stock_locations) > 1) {
            echo form_dropdown(
                'stock_location',
                $stock_locations,
                $stock_location,
                [
                    'id'         => 'stock_location',
                    'class'      => 'search-select ',
]
            );
        }
        ?>
    </div>
</div>

<div id="table_holder">
    <table id="table"></table>
</div>

<?= view('partial/footer') ?>
