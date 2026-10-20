<?php
/**
 * @var bool $logo_exists
 * @var string $controller_name
 * @var array $config
 */
?>

<?= form_open('config/saveInfo/', ['id' => 'info_config_form', 'enctype' => 'multipart/form-data', 'class' => 'ospos-form']) ?>
    <div id="config_wrapper">
        <fieldset id="config_info">

            <div id="required_fields_message"><?= lang('Common.fields_required_message') ?></div>
            <ul id="info_error_message_box" class="error_message_box"></ul>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.company'), 'company', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-house"></span>
                        </span>
                        <?= form_input([
                            'name'  => 'company',
                            'id'    => 'company',
                            'class' => 'form-control form-control-sm required',
                            'value' => $config['company']
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.company_logo'), 'company_logo', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="file-upload <?= $logo_exists ? 'file-upload-exists' : 'file-upload-new' ?>" data-file-upload>
                        <div class="file-upload-new img-thumbnail" style="width: 200px; height: 200px;"></div>
                        <div class="file-upload-preview file-upload-exists img-thumbnail" style="max-width: 200px; max-height: 200px;">
                            <img data-src="holder.js/100%x100%" alt="<?= esc(lang('Config.company_logo')) ?>" src="<?= esc($logo_src, 'attr') ?>" style="max-height: 100%; max-width: 100%;">
                        </div>
                        <div>
                            <span class="btn btn-secondary btn-sm btn-file">
                                <span class="file-upload-new"><?= lang('Config.company_select_image') ?></span>
                                <span class="file-upload-exists"><?= lang('Config.company_change_image') ?></span>
                                <input type="file" name="company_logo">
                            </span>
                            <a href="#" class="btn btn-secondary btn-sm file-upload-exists" data-clear-file><?= lang('Config.company_remove_image') ?></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.address'), 'address', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <?= form_textarea([
                        'name'  => 'address',
                        'id'    => 'address',
                        'class' => 'form-control form-control-sm required',
                        'style'    => 'resize: vertical',
                        'value' => $config['address']
                    ]) ?>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.website'), 'website', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-globe"></span>
                        </span>
                        <?= form_input([
                            'name'  => 'website',
                            'id'    => 'website',
                            'class' => 'form-control form-control-sm',
                            'value' => $config['website']
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Common.email'), 'email', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-envelope"></span>
                        </span>
                        <?= form_input([
                            'name'  => 'email',
                            'id'    => 'email',
                            'type'  => 'email',
                            'class' => 'form-control form-control-sm',
                            'value' => $config['email']
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.phone'), 'phone', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-telephone"></span>
                        </span>
                        <?= form_input([
                            'type'  => 'tel',
                            'name'  => 'phone',
                            'id'    => 'phone',
                            'class' => 'form-control form-control-sm required',
                            'value' => $config['phone']
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.fax'), 'fax', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-telephone"></span>
                        </span>
                        <?= form_input([
                            'type'  => 'tel',
                            'name'  => 'fax',
                            'id'    => 'fax',
                            'class' => 'form-control form-control-sm',
                            'value' => $config['fax']
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Common.return_policy'), 'return_policy', ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <?= form_textarea([
                        'name'  => 'return_policy',
                        'id'    => 'return_policy',
                        'class' => 'form-control form-control-sm required',
                        'style'    => 'resize: vertical',
                        'value' => $config['return_policy']
                    ]) ?>
                </div>
            </div>

            <?= form_submit([
                'name'  => 'submit_info',
                'id'    => 'submit_info',
                'value' => lang('Common.submit'),
                'class' => 'btn btn-primary btn-sm float-end'
            ]) ?>

        </fieldset>
    </div>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $("a.file-upload-exists").click(function() {
            $.ajax({
                type: 'POST',
                url: '<?= "$controller_name/removeLogo"; ?>',
                dataType: 'json'
            })
        });

        $('#info_config_form').validate($.extend(form_support.handler, {

            errorLabelContainer: "#info_error_message_box",

            rules: {
                company: "required",
                address: "required",
                phone: "required",
                email: "email",
                return_policy: "required"
            },

            messages: {
                company: "<?= lang('Config.company_required') ?>",
                address: "<?= lang('Config.address_required') ?>",
                phone: "<?= lang('Config.phone_required') ?>",
                email: "<?= lang('Common.email_invalid_format') ?>",
                return_policy: "<?= lang('Config.return_policy_required') ?>"
            }
        }));
    });
</script>
