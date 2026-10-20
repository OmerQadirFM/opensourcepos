/* Shared Bootstrap 5 controls for full pages and asynchronously loaded dialogs. */
(function(OSPOS, $) {
    'use strict';

    let notificationOptions = {placement: {align: 'end', from: 'top'}};

    $.notifyDefaults = function(options) {
        notificationOptions = $.extend(true, {}, notificationOptions, options);
    };

    $.notify = function(content, options) {
        const settings = $.extend(true, {}, notificationOptions, options);
        const placement = settings.placement;
        const container = document.createElement('div');
        container.className = 'ospos-notification alert alert-dismissible shadow';
        container.classList.add('alert-' + (['success', 'danger', 'warning', 'info'].includes(settings.type) ? settings.type : 'info'));
        container.setAttribute('role', 'status');
        container.style[placement.from === 'bottom' ? 'bottom' : 'top'] = '1rem';
        if (placement.align === 'center') {
            container.style.left = '50%';
            container.style.transform = 'translateX(-50%)';
        } else if (['left', 'right'].includes(placement.align)) {
            container.style[placement.align] = '1rem';
        } else {
            container.style.insetInlineEnd = '1rem';
        }
        const message = document.createElement('span');
        message.textContent = typeof content === 'object' ? content.message : content;
        const close = document.createElement('button');
        close.type = 'button';
        close.className = 'btn-close';
        close.setAttribute('data-bs-dismiss', 'alert');
        close.setAttribute('aria-label', window.lang ? lang.line('common_close') : 'Close');
        container.append(message, close);
        document.body.append(container);
        const alert = bootstrap.Alert.getOrCreateInstance(container);
        setTimeout(() => { if (container.isConnected) alert.close(); }, settings.delay ?? 5000);
        return {close: () => alert.close()};
    };

    OSPOS.enhanceSelects = function(root) {
        root.querySelectorAll('select.form-control').forEach(select => {
            select.classList.replace('form-control', 'form-select');
        });
        root.querySelectorAll('select.search-select, select[data-role="tags"]').forEach(select => {
            if (select.tomselect) return;
            const tags = select.dataset.role === 'tags';
            const searchable = tags || select.dataset.liveSearch === 'true' || select.multiple;
            select.classList.add('form-select', 'form-select-sm');
            new TomSelect(select, {
                create: tags,
                placeholder: select.dataset.placeholder,
                controlInput: searchable ? undefined : null,
                plugins: select.multiple ? ['remove_button'] : [],
                maxOptions: null,
                closeAfterSelect: !select.multiple,
                hidePlaceholder: true,
                onInitialize: function() {
                    if (select.disabled) this.disable();
                }
            });
        });
    };

    OSPOS.datePicker = function(selector, options) {
        $(selector).each(function() {
            if (this._flatpickr) this._flatpickr.destroy();
            flatpickr(this, {
                appendTo: this.closest('.modal') || document.body,
                allowInput: true,
                disableMobile: true,
                enableTime: options.enableTime ?? /[Hh]/.test(options.format),
                enableSeconds: /ss/.test(options.format),
                time_24hr: options.time24hr,
                minuteIncrement: 1,
                locale: options.locale ?? 'default',
                minDate: options.minDate,
                dateFormat: options.format,
                parseDate: value => {
                    const date = moment(value, options.format, true);
                    return date.isValid() ? date.toDate() : undefined;
                },
                formatDate: date => moment(date).format(options.format),
                onClose: () => $(this).trigger('change')
            });
        });
    };

    OSPOS.init = function(root = document) {
        OSPOS.enhanceSelects(root);
        root.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(element => {
            bootstrap.Tooltip.getOrCreateInstance(element, {container: 'body'});
        });
        root.querySelectorAll('input[data-ospos-toggle]').forEach(input => {
            if (input.dataset.switchReady) return;
            input.dataset.switchReady = 'true';
            const label = document.createElement('label');
            label.className = 'form-check form-switch d-flex align-items-center gap-2 mb-0';
            input.before(label);
            input.classList.add('form-check-input');
            input.setAttribute('role', 'switch');
            const text = document.createElement('span');
            const update = () => {
                const value = document.createElement('span');
                value.innerHTML = DOMPurify.sanitize(input.checked ? input.dataset.on : input.dataset.off);
                text.textContent = value.textContent;
            };
            input.addEventListener('change', update);
            label.append(input, text);
            update();
        });
        root.querySelectorAll('input[type="checkbox"]:not([data-ospos-toggle]), input[type="radio"]').forEach(input => {
            input.classList.add('form-check-input');
        });
    };

    $(document).on('change', '[data-file-upload] input[type="file"]', function() {
        const wrapper = this.closest('[data-file-upload]');
        const file = this.files[0];
        wrapper.classList.toggle('file-upload-exists', Boolean(file));
        wrapper.classList.toggle('file-upload-new', !file);
        const filename = wrapper.querySelector('.file-upload-filename');
        if (filename) filename.textContent = file ? file.name : '';
        const preview = wrapper.querySelector('.file-upload-preview');
        if (preview && file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = () => {
                const image = document.createElement('img');
                image.src = reader.result;
                image.alt = file.name;
                image.className = 'img-fluid';
                preview.replaceChildren(image);
            };
            reader.readAsDataURL(file);
        }
    });
    $(document).on('click', '[data-clear-file]', function(event) {
        event.preventDefault();
        const wrapper = this.closest('[data-file-upload]');
        wrapper.querySelector('input[type="file"]').value = '';
        wrapper.classList.replace('file-upload-exists', 'file-upload-new');
        const filename = wrapper.querySelector('.file-upload-filename');
        if (filename) filename.textContent = '';
        const preview = wrapper.querySelector('.file-upload-preview');
        if (preview) preview.replaceChildren();
    });
    $(function() { OSPOS.init(); });
})(window.OSPOS = window.OSPOS || {}, jQuery);
