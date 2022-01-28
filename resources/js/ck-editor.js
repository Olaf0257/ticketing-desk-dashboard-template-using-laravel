//https://www.npmjs.com/package/@ckeditor/ckeditor5-build-classic
// https://ckeditor.com/docs/ckeditor5/latest/framework/guides/support/error-codes.html#error-ckeditor-duplicated-modules
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';



var selection = document.querySelector('#ticket_message') !== null;
if (selection) {
    ClassicEditor
        .create(document.querySelector('#ticket_message'))
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
}

var selection = document.querySelector('#ticket_reply') !== null;
if (selection) {
    ClassicEditor
        .create(document.querySelector('#ticket_reply'))
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
}

var selection = document.querySelector('#ticket_note') !== null;
if (selection) {
    ClassicEditor
        .create(document.querySelector('#ticket_note'))
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('There was a problem initializing the editor.', error);
        });
}