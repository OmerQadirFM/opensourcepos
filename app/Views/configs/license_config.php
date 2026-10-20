<?php
/**
 * @var array $licenses
 */
?>

<?= form_open('', ['id' => 'license_config_form', 'enctype' => 'multipart/form-data', 'class' => 'ospos-form']) ?>
    <div id="config_wrapper">
        <fieldset>

            <?php
            $counter = 0;
            foreach ($licenses as $license) {
            ?>
                <div class="row mb-3 ">
                    <?= form_label($license['title'], 'license', ['class' => 'col-form-label col-3 col-sm-2']) ?>
                    <div class="col-9 col-lg-8">
                        <?= form_textarea([
                            'name'     => 'license',
                            'id'       => 'license_' . $counter++,    // TODO: String Interpolation
                            'class'    => 'form-control font-monospace',
                            'style'    => 'resize: vertical',
                            'rows'     => '14',
                            'readonly' => '',
                            'value'    => $license['text']
                        ]) ?>
                    </div>
                </div>
            <?php } ?>

        </fieldset>
    </div>
<?= form_close() ?>
