import assert from 'node:assert/strict';
import {readFileSync} from 'node:fs';
import {JSDOM, VirtualConsole} from 'jsdom';

export function createPage(t, html = '') {
    const errors = [];
    const virtualConsole = new VirtualConsole();
    virtualConsole.on('jsdomError', error => errors.push(error.message));
    virtualConsole.on('error', error => errors.push(String(error)));
    const page = new JSDOM('<!doctype html><html dir="rtl"><body>' + html + '</body></html>', {
        url: 'http://localhost/', runScripts: 'outside-only', pretendToBeVisual: true, virtualConsole
    });
    t.after(() => { page.window.close(); assert.deepEqual(errors, []); });
    const scripts = [
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap/dist/js/bootstrap.bundle.js',
        'node_modules/moment/min/moment.min.js',
        'node_modules/flatpickr/dist/flatpickr.js',
        'node_modules/tom-select/dist/js/tom-select.complete.js',
        'node_modules/dompurify/dist/purify.js',
        'public/js/ui.js'
    ];
    for (const script of scripts) {
        page.window.eval(readFileSync(new URL('../../' + script, import.meta.url), 'utf8'));
    }
    return page.window;
}
