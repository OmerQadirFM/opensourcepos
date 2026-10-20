<?php
/**
 * @var array $themes
 * @var array $image_allowed_types
 * @var array $selected_image_allowed_types
 * @var bool $show_office_group
 * @var string $controller_name
 * @var array $config
 */

$selectedTheme = in_array($config['theme'] ?? '', ['', 'paper', 'readable'], true) ? 'flatly' : $config['theme'];
$themePreviewUrl = $selectedTheme === 'bootstrap'
    ? 'https://getbootstrap.com/docs/5.3/examples/'
    : 'https://bootswatch.com/' . $selectedTheme . '/';
?>

<?= form_open('config/saveGeneral/', ['id' => 'general_config_form', 'enctype' => 'multipart/form-data', 'class' => 'ospos-form']) ?>
    <div id="config_wrapper">
        <fieldset id="config_info">

            <div id="required_fields_message"><?= lang('Common.fields_required_message') ?></div>
            <ul id="general_error_message_box" class="error_message_box"></ul>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.theme'), 'theme', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                    <?= form_dropdown(
                        'theme',
                        $themes,
                        $selectedTheme,
                        'class="form-control form-control-sm" id="theme-change"'
                    ) ?>
                </div>
                <div class="col-4 col-sm-6 col-md-7 col-lg-8">
                    <p class="form-control-plaintext">
                        <a href="<?= esc($themePreviewUrl, 'attr') ?>" target="_blank" rel="noopener">
                            <span><?= lang('Config.theme_preview') . ' ' . ucfirst(esc($selectedTheme)) . ' ' ?></span>
                            <span class="bi bi-box-arrow-up-right"></span>
                        </a>
                    </p>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.login_form'), 'login_form', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-4 col-md-3 col-lg-2">
                    <?= form_dropdown(
                        'login_form',
                        [
                            'floating_labels' => lang('Config.floating_labels'),
                            'input_groups'    => lang('Config.input_groups')
                        ],
                        $config['login_form'],
                        'class="form-control form-control-sm"'
                    ) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.default_sales_discount'), 'default_sales_discount', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-4 col-md-3 col-lg-2">
                    <div class="input-group">
                        <?= form_input([
                            'name'  => 'default_sales_discount',
                            'id'    => 'default_sales_discount',
                            'class' => 'form-control form-control-sm required',
                            'type'  => 'number',
                            'min'   => 0,
                            'max'   => 100,
                            'value' => $config['default_sales_discount']
                        ]) ?>
                        <span class="d-flex align-items-center">
                            <?= form_checkbox([
                                'id'           => 'default_sales_discount_type',
                                'name'         => 'default_sales_discount_type',
                                'value'        => 1,
                                'data-ospos-toggle'  => 'toggle',
'data-on'      => '<strong>' . $config['currency_symbol'] . '</strong>',
                                'data-off'     => '<strong>%</strong>',
                                'checked'      => $config['default_sales_discount_type'] == 1
                            ]) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.default_receivings_discount'), 'default_receivings_discount', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-4 col-md-3 col-lg-2">
                    <div class="input-group">
                        <?= form_input([
                            'name'  => 'default_receivings_discount',
                            'id'    => 'default_receivings_discount',
                            'class' => 'form-control form-control-sm required',
                            'type'  => 'number',
                            'min'   => 0,
                            'max'   => 100,
                            'value' => $config['default_receivings_discount']
                        ]) ?>
                        <span class="d-flex align-items-center">
                            <?= form_checkbox([
                                'id'           => 'default_receivings_discount_type',
                                'name'         => 'default_receivings_discount_type',
                                'value'        => 1,
                                'data-ospos-toggle'  => 'toggle',
'data-on'      => '<b>' . $config['currency_symbol'] . '</b>',
                                'data-off'     => '<b>%</b>',
                                'checked'      => $config['default_receivings_discount_type'] == 1
                            ]) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.enforce_privacy'), 'enforce_privacy', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'enforce_privacy',
                        'id'      => 'enforce_privacy',
                        'value'   => 'enforce_privacy',
                        'checked' => $config['enforce_privacy'] == 1
                    ]) ?>
                    &nbsp;
                    <label class="col-form-label">
                        <span class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= lang('Config.enforce_privacy_tooltip') ?>"></span>
                    </label>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.receiving_calculate_average_price'), 'receiving_calculate_average_price', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'receiving_calculate_average_price',
                        'id'      => 'receiving_calculate_average_price',
                        'value'   => 'receiving_calculate_average_price',
                        'checked' => $config['receiving_calculate_average_price'] == 1
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.lines_per_page'), 'lines_per_page', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-4 col-md-3 col-lg-2">
                    <?= form_input([
                        'name'  => 'lines_per_page',
                        'id'    => 'lines_per_page',
                        'class' => 'form-control form-control-sm required',
                        'type'  => 'number',
                        'min'   => 10,
                        'max'   => 1000,
                        'value' => $config['lines_per_page']
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.notify_alignment'), 'notify_horizontal_position', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-4 col-md-3 col-lg-2">
                    <?= form_dropdown(
                        'notify_vertical_position',
                        [
                            'top'    => lang('Config.top'),
                            'bottom' => lang('Config.bottom')
                        ],
                        $config['notify_vertical_position'],
                        'class="form-control form-control-sm"'
                    ) ?>
                </div>
                <div class="col-4 col-md-3 col-lg-2">
                    <?= form_dropdown(
                        'notify_horizontal_position',
                        [
                            'left'   => lang('Config.left'),
                            'center' => lang('Config.center'),
                            'right'  => lang('Config.right')
                        ],
                        $config['notify_horizontal_position'],
                        'class="form-control form-control-sm"'
                    ) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.image_restrictions'), 'image_restrictions', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-2">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-arrows"></span>
                        </span>
                        <?= form_input([
                            'name'           => 'image_max_width',
                            'id'             => 'image_max_width',
                            'class'          => 'form-control form-control-sm required',
                            'type'           => 'number',
                            'min'            => 128,
                            'max'            => 3840,
                            'value'          => $config['image_max_width'],
                            'data-bs-toggle'    => 'tooltip',
                            'data-bs-placement' => 'top',
                            'title'          => lang('Config.image_max_width_tooltip')
                        ]) ?>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-arrows-vertical"></span>
                        </span>
                        <?= form_input([
                            'name'           => 'image_max_height',
                            'id'             => 'image_max_height',
                            'class'          => 'form-control form-control-sm required',
                            'type'           => 'number',
                            'min'            => 128,
                            'max'            => 3840,
                            'value'          => $config['image_max_height'],
                            'data-bs-toggle'    => 'tooltip',
                            'data-bs-placement' => 'top',
                            'title'          => lang('Config.image_max_height_tooltip')
                        ]) ?>
                    </div>
                </div>
                <div class="col-2">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-hdd"></span>
                        </span>
                        <?= form_input([
                            'name'           => 'image_max_size',
                            'id'             => 'image_max_size',
                            'class'          => 'form-control form-control-sm required',
                            'type'           => 'number',
                            'min'            => 128,
                            'max'            => 2048,
                            'value'          => $config['image_max_size'],
                            'data-bs-toggle'    => 'tooltip',
                            'data-bs-placement' => 'top',
                            'title'          => lang('Config.image_max_size_tooltip')
                        ]) ?>
                    </div>
                </div>
                <div class="col-3 col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm"><?= lang('Config.image_allowed_file_types') ?></span>
                        <?= form_multiselect([
                            'name'                      => 'image_allowed_types[]',
                            'options'                   => $image_allowed_types,
                            'selected'                  => $selected_image_allowed_types,
                            'id'                        => 'image_allowed_types',
                            'class'                     => 'search-select ',
                            'data-placeholder'   => lang('Common.none_selected_text'),
]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.gcaptcha_enable'), 'gcaptcha_enable', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'gcaptcha_enable',
                        'id'      => 'gcaptcha_enable',
                        'value'   => 'gcaptcha_enable',
                        'checked' => $config['gcaptcha_enable'] == 1
                    ]) ?>
                    &nbsp;
                    <label class="col-form-label">
                        <a href="https://www.google.com/recaptcha/admin" target="_blank">
                            <span class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= lang('Config.gcaptcha_tooltip') ?>"></span>
                        </a>
                    </label>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.gcaptcha_site_key'), 'config_gcaptcha_site_key', ['class' => 'col-form-label col-3 col-sm-2 required', 'id' => 'config_gcaptcha_site_key']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <?= form_input([
                        'name'  => 'gcaptcha_site_key',
                        'id'    => 'gcaptcha_site_key',
                        'class' => 'form-control form-control-sm required',
                        'value' => $config['gcaptcha_site_key']
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.gcaptcha_secret_key'), 'config_gcaptcha_secret_key', ['class' => 'col-form-label col-3 col-sm-2 required', 'id' => 'config_gcaptcha_secret_key']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <?= form_input([
                        'name'  => 'gcaptcha_secret_key',
                        'id'    => 'gcaptcha_secret_key',
                        'class' => 'form-control form-control-sm required',
                        'value' => $config['gcaptcha_secret_key']
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.suggestions_layout'), 'suggestions_layout', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-3">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm"><?= lang('Config.suggestions_first_column') ?></span>
                        <?= form_dropdown(
                            'suggestions_first_column',
                            [
                                'name'        => lang('Items.name'),
                                'item_number' => lang('Items.number_information'),
                                'unit_price'  => lang('Items.unit_price'),
                                'cost_price'  => lang('Items.cost_price')
                            ],
                            $config['suggestions_first_column'],
                            'class="form-control form-control-sm"'
                        ) ?>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm"><?= lang('Config.suggestions_second_column') ?></span>
                        <?= form_dropdown(
                            'suggestions_second_column',
                            [
                                ''            => lang('Config.none'),
                                'name'        => lang('Items.name'),
                                'item_number' => lang('Items.number_information'),
                                'unit_price'  => lang('Items.unit_price'),
                                'cost_price'  => lang('Items.cost_price')
                            ],
                            $config['suggestions_second_column'],
                            'class="form-control form-control-sm"'
                        ) ?>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm"><?= lang('Config.suggestions_third_column') ?></span>
                        <?= form_dropdown(
                            'suggestions_third_column',
                            [
                                ''            => lang('Config.none'),
                                'name'        => lang('Items.name'),
                                'item_number' => lang('Items.number_information'),
                                'unit_price'  => lang('Items.unit_price'),
                                'cost_price'  => lang('Items.cost_price')
                            ],
                            $config['suggestions_third_column'],
                            'class="form-control form-control-sm"'
                        ) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.giftcard_number'), 'giftcard_number', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <label class="d-inline-flex align-items-center gap-1">
                        <?= form_radio([
                            'name'    => 'giftcard_number',
                            'value'   => 'series',
                            'checked' => $config['giftcard_number'] == 'series'
                        ]) ?>
                        <?= lang('Config.giftcard_series') ?>
                    </label>
                    <label class="d-inline-flex align-items-center gap-1">
                        <?= form_radio([
                            'name'    => 'giftcard_number',
                            'value'   => 'random',
                            'checked' => $config['giftcard_number'] == 'random'
                        ]) ?>
                        <?= lang('Config.giftcard_random') ?>
                    </label>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.derive_sale_quantity'), 'derive_sale_quantity', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'derive_sale_quantity',
                        'id'      => 'derive_sale_quantity',
                        'value'   => 'derive_sale_quantity',
                        'checked' => $config['derive_sale_quantity'] == 1
                    ]) ?>
                    &nbsp;
                    <label class="col-form-label">
                        <span class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= lang('Config.derive_sale_quantity_tooltip') ?>"></span>
                    </label>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.show_office_group'), 'show_office_group', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'show_office_group',
                        'id'      => 'show_office_group',
                        'value'   => 'show_office_group',
                        'checked' => $show_office_group > 0
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.multi_pack_enabled'), 'multi_pack_enabled', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'multi_pack_enabled',
                        'id'      => 'multi_pack_enabled',
                        'value'   => 'multi_pack_enabled',
                        'checked' => $config['multi_pack_enabled'] == 1
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.include_hsn'), 'include_hsn', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'include_hsn',
                        'id'      => 'include_hsn',
                        'value'   => 'include_hsn',
                        'checked' => $config['include_hsn'] == 1
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.category_dropdown'), 'category_dropdown', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9">
                    <?= form_checkbox([
                        'name'    => 'category_dropdown',
                        'id'      => 'category_dropdown',
                        'value'   => 'category_dropdown',
                        'checked' => $config['category_dropdown'] == 1
                    ]) ?>
                </div>
            </div>

            <?= form_submit([
                'name'  => 'submit_general',
                'id'    => 'submit_general',
                'value' => lang('Common.submit'),
                'class' => 'btn btn-primary btn-sm float-end'
            ]) ?>

        </fieldset>
    </div>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        const enable_disable_gcaptcha_enable = (function() {
            const gcaptcha_enable = $("#gcaptcha_enable").is(":checked");
            if (gcaptcha_enable) {
                $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", !gcaptcha_enable).addClass("text-danger required");
                $("#config_gcaptcha_site_key, #config_gcaptcha_secret_key").addClass("text-danger required");
            } else {
                $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", gcaptcha_enable).removeClass("text-danger required");
                $("#config_gcaptcha_site_key, #config_gcaptcha_secret_key").removeClass("text-danger required");
            }

            return arguments.callee;
        })();

        $("#gcaptcha_enable").change(enable_disable_gcaptcha_enable);

        $('#general_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#general_error_message_box",

            rules: {
                lines_per_page: {
                    required: true,
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                default_sales_discount: {
                    required: true,
                    remote: "<?= "$controller_name/checkNumeric" ?>"
                },
                gcaptcha_site_key: {
                    required: "#gcaptcha_enable:checked"
                },
                gcaptcha_secret_key: {
                    required: "#gcaptcha_enable:checked"
                }
            },

            messages: {
                default_sales_discount: {
                    required: "<?= lang('Config.default_sales_discount_required') ?>",
                    number: "<?= lang('Config.default_sales_discount_number') ?>"
                },
                lines_per_page: {
                    required: "<?= lang('Config.lines_per_page_required') ?>",
                    number: "<?= lang('Config.lines_per_page_number') ?>"
                },
                gcaptcha_site_key: {
                    required: "<?= lang('Config.gcaptcha_site_key_required') ?>"
                },
                gcaptcha_secret_key: {
                    required: "<?= lang('Config.gcaptcha_secret_key_required') ?>"
                }
            },

            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    beforeSerialize: function(arr, $form, options) {
                        $("#gcaptcha_site_key, #gcaptcha_secret_key").prop("disabled", false);
                        return true;
                    },
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                        // Set back disabled state
                        enable_disable_gcaptcha_enable();
                    },
                    dataType: 'json'
                });
            }
        }));
    });
</script>
