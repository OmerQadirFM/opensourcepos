<script type="text/javascript">
    (function(lang, $) {

        const lines = {
            'common_submit': "<?= esc(lang('Common.submit'), 'js') ?>",
            'common_close': "<?= esc(lang('Common.close'), 'js') ?>",
            'common_correct_errors': "<?= esc(lang('Common.correct_errors'), 'js') ?>"
        };

        $.extend(lang, {
            line: function(key) {
                return lines[key];
            }
        });

    })(window.lang = window.lang || {}, jQuery);
</script>
