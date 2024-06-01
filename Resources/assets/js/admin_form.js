function serializeFormNews($form) {

    let formData = new FormData($form[0]);
    let additionalParams = {};

    // Append additional parameters to FormData
    for (let key in additionalParams) {
        if (additionalParams.hasOwnProperty(key)) {
            formData.append(key, additionalParams[key]);
        }
    }

    return formData;
}

$(document).on('submit', '[data-newsform]', async (ev) => {
    let $form = $(ev.currentTarget);

    ev.preventDefault();

    let path = $form.data('newsform'),
        form = serializeFormNews($form),
        page = $form.data('page'),
        id = $form.data('id');

    let url = `admin/api/${page}/${path}`,
        method = 'POST';

    if (path === 'edit') {
        url = `admin/api/${page}/edit/${id}`;
    }

    let activeEditorElement = document.querySelector(
        '.tab-content:not([hidden]) [data-editorjs]',
    );
    let activeEditor = window['editorInstance_' + activeEditorElement.id];

    let editorData = await activeEditor.save();
    form.append('blocks', JSON.stringify(editorData.blocks));

    if (ev.target.checkValidity()) {
        sendRequest(form, url, method);
    }
});
