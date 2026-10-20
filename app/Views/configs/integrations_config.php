<?php
/**
 * @var array $mailchimp
 * @var string $controller_name
 */
?>

<?= form_open('config/saveMailchimp/', ['id' => 'mailchimp_config_form', 'enctype' => 'multipart/form-data', 'class' => 'ospos-form']) ?>
    <div id="config_wrapper">
        <fieldset id="config_info">

            <div id="required_fields_message"><?= lang('Common.fields_required_message') ?></div>
            <div id="integrations_header"><?= lang('Config.mailchimp_configuration') ?></div>
            <ul id="mailchimp_error_message_box" class="error_message_box"></ul>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.mailchimp_api_key'), 'mailchimp_api_key', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-8 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-cloud"></span>
                        </span>
                        <?php $apiKeySet = !empty($mailchimp['api_key_set']) ?>
                        <input type="password"
                               name="mailchimp_api_key"
                               id="mailchimp_api_key"
                               class="form-control form-control-sm"
                               placeholder="<?= $apiKeySet ? lang('Config.mailchimp_api_key_set') : esc(lang('Config.mailchimp_api_key')) ?>"
                               autocomplete="off">
                    </div>
                </div>
                <div class="col-1 col-sm-4 col-md-5 col-lg-6">
                    <p class="form-control-plaintext">
                        <a href="https://eepurl.com/b9a05b" target="_blank">
                            <span class="bi bi-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="<?= lang('Config.mailchimp_tooltip') ?>"></span>
                        </a>
                    </p>
                </div>
            </div>

            <div class="row mb-3 ">
                <?= form_label(lang('Config.mailchimp_lists'), 'mailchimp_list_id', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                <div class="col-9 col-sm-6 col-md-5 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text form-control-sm">
                            <span class="bi bi-person"></span>
                        </span>
                        <?= form_dropdown(
                            'mailchimp_list_id',
                            $mailchimp['lists'],
                            $mailchimp['list_id'],
                            'id="mailchimp_list_id" class="form-control form-control-sm"'
                        ) ?>
                    </div>
                </div>
            </div>

            <?= form_submit([
                'name'  => 'submit_mailchimp',
                'id'    => 'submit_mailchimp',
                'value' => lang('Common.submit'),
                'class' => 'btn btn-primary btn-sm float-end'
            ]) ?>

        </fieldset>
    </div>
<?= form_close() ?>

<script type="text/javascript">
    // Validation and submit handling
    $(document).ready(function() {
        $('#mailchimp_api_key').change(function() {
            $.post("<?= "$controller_name/checkMailchimpApiKey" ?>", {
                    'mailchimp_api_key': $('#mailchimp_api_key').val()
                },
                function(response) {
                    $.notify({
                        message: response.message
                    }, {
                        type: response.success ? 'success' : 'danger'
                    });
                    $('#mailchimp_list_id').empty();
                    $.each(response.mailchimp_lists, function(val, text) {
                        $('#mailchimp_list_id').append(new Option(text, val));
                    });
                    $('#mailchimp_list_id').prop('selectedIndex', 0);
                },
                'json'
            );
        });

        $('#mailchimp_config_form').validate($.extend(form_support.handler, {
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    success: function(response) {
                        $.notify({
                            message: response.message
                        }, {
                            type: response.success ? 'success' : 'danger'
                        })
                    },
                    dataType: 'json'
                });
            },

            errorLabelContainer: '#mailchimp_error_message_box'
        }));
    });
</script>
