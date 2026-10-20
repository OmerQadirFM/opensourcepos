import assert from 'node:assert/strict';
import test from 'node:test';
import {createPage} from './helpers.js';

test('notifications render untrusted messages as text and can be dismissed', t => {
    const window = createPage(t);
    const message = '<img src=x onerror="alert(1)">';
    const notification = window.jQuery.notify({message}, {type: 'danger'});
    assert.equal(window.document.querySelector('[role="status"] span').textContent, message);
    assert.equal(window.document.querySelector('img'), null);
    notification.close();
    assert.equal(window.document.querySelector('.ospos-notification'), null);
});

test('enhanced selects retain submitted selections, disabled state, and initialize once', t => {
    const window = createPage(t, '<form><select name="filter" class="search-select" disabled><option value="a">Alpha</option><option selected value="b">Beta</option></select></form>');
    window.OSPOS.init();
    const select = window.document.querySelector('select');
    const control = select.tomselect;
    assert.equal(control.getValue(), 'b');
    assert.equal(control.isDisabled, true);
    window.OSPOS.init();
    assert.equal(select.tomselect, control);
});

test('switch labels follow state without losing form values or change events', t => {
    const window = createPage(t, '<form><input type="checkbox" name="discount" value="1" data-ospos-toggle="toggle" data-on="&lt;b&gt;$&lt;/b&gt;" data-off="%"></form>');
    let changes = 0;
    const input = window.document.querySelector('input');
    input.addEventListener('change', () => changes++);
    window.OSPOS.init();
    window.OSPOS.init();
    assert.equal(window.document.querySelectorAll('.form-switch').length, 1);
    input.click();
    assert.equal(changes, 1);
    assert.equal(new window.FormData(window.document.querySelector('form')).get('discount'), '1');
    assert.equal(window.document.querySelector('.form-switch span').textContent, '$');
});

test('date pickers preserve day-first dates and time including seconds', t => {
    const window = createPage(t, '<input id="date" value="20/10/2026 14:35:27">');
    window.OSPOS.datePicker('#date', {format: 'DD/MM/YYYY HH:mm:ss', time24hr: true});
    const input = window.document.querySelector('input');
    const first = input._flatpickr;
    assert.equal(window.moment(first.selectedDates[0]).format('YYYY-MM-DD HH:mm:ss'), '2026-10-20 14:35:27');
    first.setDate('21/10/2026 09:15:30');
    assert.equal(input.value, '21/10/2026 09:15:30');
    window.OSPOS.datePicker('#date', {format: 'DD/MM/YYYY HH:mm:ss', time24hr: true});
    assert.notEqual(input._flatpickr, first);
});

test('clearing a selected file resets the control and preview', t => {
    const window = createPage(t, '<div data-file-upload class="file-upload file-upload-exists"><input type="file"><span class="file-upload-filename">sample.csv</span><div class="file-upload-preview"><img alt="Preview"></div><a href="#" data-clear-file>Remove</a></div>');
    window.document.querySelector('a').click();
    assert.equal(window.document.querySelector('.file-upload').classList.contains('file-upload-new'), true);
    assert.equal(window.document.querySelector('.file-upload-filename').textContent, '');
    assert.equal(window.document.querySelector('.file-upload-preview img'), null);
});

test('choosing an image shows a safe filename and preview', async t => {
    const window = createPage(t, '<div data-file-upload class="file-upload file-upload-new"><input type="file" name="avatar"><span class="file-upload-filename"></span><div class="file-upload-preview"></div></div>');
    const input = window.document.querySelector('input');
    const file = new window.File(['sample image'], '<sample>.png', {type: 'image/png'});
    Object.defineProperty(input, 'files', {value: [file]});
    const previewReady = new Promise(resolve => {
        const observer = new window.MutationObserver(() => { observer.disconnect(); resolve(); });
        observer.observe(window.document.querySelector('.file-upload-preview'), {childList: true});
    });
    input.dispatchEvent(new window.Event('change', {bubbles: true}));
    await previewReady;
    assert.equal(window.document.querySelector('.file-upload-filename').textContent, '<sample>.png');
    assert.equal(window.document.querySelector('.file-upload').classList.contains('file-upload-exists'), true);
    assert.ok(window.document.querySelector('.file-upload-preview img').src.startsWith('data:image/png;base64,'));
});

test('date-only fields do not display time controls', t => {
    const window = createPage(t, '<input id="date" value="20/10/2026">');
    window.OSPOS.datePicker('#date', {format: 'DD/MM/YYYY'});
    assert.equal(window.document.querySelector('input')._flatpickr.config.enableTime, false);
    assert.equal(window.document.querySelector('input').value, '20/10/2026');
});

test('calendar popups remain inside the modal focus boundary', t => {
    const window = createPage(t, '<div class="modal"><input id="date" value="20/10/2026"></div>');
    window.OSPOS.datePicker('#date', {format: 'DD/MM/YYYY'});
    assert.equal(window.document.querySelectorAll('.modal .flatpickr-calendar').length, 1);
});
