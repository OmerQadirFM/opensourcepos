<div class="container-fluid" style="padding-inline: 0;">
    <ul class="nav nav-tabs" id="myTabs">
        <li class="nav-item">
        <a href="#system_tabs" data-bs-toggle="tab" role="tab" class="nav-link active" title="<?= lang('Config.system_info') ?>"><?= lang('Config.system_info') ?></a></li>
        <li class="nav-item">
        <a href="#email_tabs" data-bs-toggle="tab" role="tab" class="nav-link" title="<?= lang('Config.email_configuration') ?>"><?= lang('Config.email') ?></a></li>
        <li class="nav-item">
        <a href="#message_tabs" data-bs-toggle="tab" role="tab" class="nav-link" title="<?= lang('Config.message_configuration') ?>"><?= lang('Config.message') ?></a></li>
        <li class="nav-item">
        <a href="#integrations_tabs" data-bs-toggle="tab" role="tab" class="nav-link" title="<?= lang('Config.integrations_configuration') ?>"><?= lang('Config.integrations') ?></a></li>
        <li class="nav-item">
        <a href="#license_tabs" data-bs-toggle="tab" role="tab" class="nav-link" title="<?= lang('Config.license_configuration') ?>"><?= lang('Config.license') ?></a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="system_tabs"><?= view('configs/system_info') ?></div>
        <div class="tab-pane" id="email_tabs"><?= view('configs/email_config') ?></div>
        <div class="tab-pane" id="message_tabs"><?= view('configs/message_config') ?></div>
        <div class="tab-pane" id="integrations_tabs"><?= view('configs/integrations_config') ?></div>
        <div class="tab-pane" id="license_tabs"><br><?= view('configs/license_config') ?></div>
    </div>
</div>
