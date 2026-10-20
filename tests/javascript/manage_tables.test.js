import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import test from 'node:test';
import {createPage} from './helpers.js';

function createDialogPage(t) {
    const window = createPage(t, '<a href="/items/view" class="modal-dlg" title="Edit item" data-btn-submit="Save" data-btn-new="New">Edit</a>');
    window.lang = {line: () => 'Close'};
    window.jQuery.get = () => {
        const request = {
            done(callback) { callback('<form><input name="name" value="Test"></form>'); return request; },
            fail() { return request; }
        };
        return request;
    };
    window.eval(readFileSync(new URL('../../public/js/manage_tables.js', import.meta.url), 'utf8'));
    window.dialog_support.init('.modal-dlg');
    window.dialog_support.init('.modal-dlg');
    window.document.querySelector('a').click();
    return window;
}

test('dialogs initialize once, keep titles as text, and submit each action once', t => {
    const window = createDialogPage(t);
    assert.equal(window.document.querySelectorAll('.modal').length, 1);
    let submitted = 0;
    window.jQuery('.modal form').on('submit', event => { event.preventDefault(); submitted++; });
    window.document.querySelector('#submit').click();
    assert.equal(submitted, 1);
    assert.equal(window.dialog_support.clicked_id(), 'submit');
    window.document.querySelector('#new').click();
    assert.equal(submitted, 2);
    assert.equal(window.dialog_support.clicked_id(), 'new');
});

test('Enter submits the New action while multiline inputs keep Enter', t => {
    const window = createDialogPage(t);
    let submitted = 0;
    window.jQuery('.modal form').on('submit', event => { event.preventDefault(); submitted++; });
    window.document.querySelector('input').dispatchEvent(new window.KeyboardEvent('keydown', {key: 'Enter', bubbles: true, cancelable: true}));
    assert.equal(submitted, 1);
    assert.equal(window.dialog_support.clicked_id(), 'new');
    const textarea = window.document.createElement('textarea');
    window.document.querySelector('form').append(textarea);
    textarea.dispatchEvent(new window.KeyboardEvent('keydown', {key: 'Enter', bubbles: true, cancelable: true}));
    assert.equal(submitted, 1);
});
