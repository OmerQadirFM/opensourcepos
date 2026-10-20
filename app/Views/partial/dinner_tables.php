<?php
/**
 * @var array $dinner_tables
 */
?>

<?php
$i = 0;

foreach ($dinner_tables as $table_key => $table) {
    $dinner_table_id = $table['dinner_table_id'];
    $dinner_table_name = $table['name'];
    ++$i;
?>

    <div class="row mb-3 " style="<?= $table['deleted'] ? 'display: none;' : 'display: block;' ?>">
        <?= form_label(lang('Config.dinner_table') . " $i", "dinner_table_$i", ['class' => 'col-form-label col-3 col-sm-2 text-danger required']) ?>
        <div class="col-7 col-sm-4 col-md-3">
            <?php $form_data = [
                'name'  => "dinner_table_$dinner_table_id",
                'id'    => "dinner_table_$dinner_table_id",
                'class' => 'dinner_table valid_chars form-control form-control-sm required',
                'value' => $dinner_table_name
            ];
            $table['deleted'] && $form_data['disabled'] = 'disabled';
            echo form_input($form_data);
            ?>
        </div>
        <span class="add_dinner_table bi bi-plus-lg" style="padding-top: 0.5em;"></span>
        <span>&nbsp;&nbsp;</span>
        <span class="remove_dinner_table bi bi-dash" style="padding-top: 0.5em;"></span>
    </div>

<?php } ?>
