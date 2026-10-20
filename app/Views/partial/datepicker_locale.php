<?php
use Config\OSPOS;

$config = config(OSPOS::class)->settings;
?>
const pickerConfig = function(overrides = {}) {
    const format = <?= json_encode($this->data['format'] ?? dateformat_momentjs($config['dateformat'] . ' ' . $config['timeformat'])) ?>;
    return Object.assign({
        format: format,
        enableTime: /[Hh]/.test(format),
        time24hr: <?= str_contains($config['timeformat'], 'H') ? 'true' : 'false' ?>,
        locale: {
            weekdays: {
                shorthand: <?= json_encode([lang('Calendar.sun'), lang('Calendar.mon'), lang('Calendar.tue'), lang('Calendar.wed'), lang('Calendar.thu'), lang('Calendar.fri'), lang('Calendar.sat')], JSON_UNESCAPED_UNICODE) ?>,
                longhand: <?= json_encode([lang('Calendar.sunday'), lang('Calendar.monday'), lang('Calendar.tuesday'), lang('Calendar.wednesday'), lang('Calendar.thursday'), lang('Calendar.friday'), lang('Calendar.saturday')], JSON_UNESCAPED_UNICODE) ?>
            },
            months: {
                shorthand: <?= json_encode([lang('Calendar.jan'), lang('Calendar.feb'), lang('Calendar.mar'), lang('Calendar.apr'), lang('Calendar.may'), lang('Calendar.jun'), lang('Calendar.jul'), lang('Calendar.aug'), lang('Calendar.sep'), lang('Calendar.oct'), lang('Calendar.nov'), lang('Calendar.dec')], JSON_UNESCAPED_UNICODE) ?>,
                longhand: <?= json_encode([lang('Calendar.january'), lang('Calendar.february'), lang('Calendar.march'), lang('Calendar.april'), lang('Calendar.may'), lang('Calendar.june'), lang('Calendar.july'), lang('Calendar.august'), lang('Calendar.september'), lang('Calendar.october'), lang('Calendar.november'), lang('Calendar.december')], JSON_UNESCAPED_UNICODE) ?>
            },
            firstDayOfWeek: <?= (int) lang('Datepicker.weekstart') ?>
        }
    }, overrides);
};
OSPOS.datePicker('.datetime', pickerConfig());
