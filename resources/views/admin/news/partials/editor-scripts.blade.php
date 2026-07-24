{{-- Quill Rich Text Editor - shared between create and edit news --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css">

<style>
.quill-wrapper .ql-toolbar.ql-snow {
    border: 1px solid #d1d5db;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
    background: #f9fafb;
    padding: 8px 12px;
    font-family: inherit;
}
.quill-wrapper .ql-container.ql-snow {
    border: 1px solid #d1d5db;
    border-radius: 0 0 8px 8px;
    font-size: 15px;
    line-height: 1.8;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}
.quill-wrapper .ql-editor {
    min-height: 400px;
    padding: 20px 24px;
    color: #111827;
}
.quill-wrapper .ql-editor.ql-blank::before {
    color: #9ca3af;
    font-style: normal;
}
.quill-wrapper .ql-snow .ql-stroke { stroke: #374151; }
.quill-wrapper .ql-snow .ql-fill { fill: #374151; }
.quill-wrapper .ql-snow.ql-toolbar button:hover .ql-stroke,
.quill-wrapper .ql-snow .ql-toolbar button.ql-active .ql-stroke,
.quill-wrapper .ql-snow .ql-toolbar .ql-picker-label:hover .ql-stroke { stroke: #00629B; }
.quill-wrapper .ql-snow.ql-toolbar button:hover .ql-fill,
.quill-wrapper .ql-snow .ql-toolbar button.ql-active .ql-fill { fill: #00629B; }
.quill-wrapper .ql-snow.ql-toolbar button:hover,
.quill-wrapper .ql-snow .ql-toolbar button.ql-active,
.quill-wrapper .ql-snow .ql-toolbar .ql-picker-label:hover { color: #00629B; }
.quill-wrapper .ql-snow .ql-picker-options { border-radius: 6px; box-shadow: 0 4px 12px rgba(0,0,0,.1); }
.quill-wrapper .ql-editor h1 { font-size: 1.75rem; font-weight: 700; margin: 1rem 0 .5rem; }
.quill-wrapper .ql-editor h2 { font-size: 1.4rem; font-weight: 700; margin: 1rem 0 .5rem; }
.quill-wrapper .ql-editor h3 { font-size: 1.15rem; font-weight: 600; margin: .75rem 0 .4rem; }
.quill-wrapper .ql-editor blockquote {
    border-left: 4px solid #00629B;
    background: #f0f7ff;
    padding: 10px 16px;
    margin: 12px 0;
    border-radius: 0 6px 6px 0;
    color: #374151;
}
.quill-wrapper .ql-editor img { max-width: 100%; border-radius: 6px; margin: 8px 0; }
.quill-wrapper .ql-editor a { color: #00629B; text-decoration: underline; }
.quill-wrapper .ql-editor pre.ql-syntax {
    background: #1e293b;
    color: #e2e8f0;
    border-radius: 6px;
    padding: 12px 16px;
    font-size: 13px;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.js"></script>
<script>
(function() {
    const toolbarOptions = [
        [{ 'header': [1, 2, 3, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'align': [] }],
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'indent': '-1' }, { 'indent': '+1' }],
        ['blockquote', 'code-block'],
        ['link', 'image'],
        ['clean']
    ];

    const quill = new Quill('#quill-editor', {
        theme: 'snow',
        modules: {
            toolbar: { container: toolbarOptions, handlers: { image: imageUploadHandler } }
        },
        placeholder: 'Tulis konten berita di sini...',
    });

    // Load initial content
    const initial = @json($initialContent ?? '');
    if (initial) {
        quill.clipboard.dangerouslyPasteHTML(initial);
    }

    // Word counter
    quill.on('text-change', function() {
        const text = quill.getText().trim();
        const words = text ? text.split(/\s+/).filter(Boolean).length : 0;
        document.getElementById('wordCounter').textContent = words;
    });

    // Sync to hidden textarea on submit
    document.getElementById('newsForm').addEventListener('submit', function() {
        document.getElementById('content').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
    });

    function imageUploadHandler() {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/jpeg,image/png,image/gif,image/webp');
        input.click();

        input.onchange = function() {
            const file = input.files[0];
            if (!file) return;

            const fd = new FormData();
            fd.append('file', file);
            fd.append('_token', document.querySelector('meta[name=csrf-token]').content);

            const range = quill.getSelection(true);

            fetch('/admin/upload-image', { method: 'POST', body: fd })
                .then(r => r.json())
                .then(data => {
                    if (data.location) {
                        quill.insertEmbed(range.index, 'image', data.location);
                        quill.setSelection(range.index + 1);
                    }
                })
                .catch(() => alert('Gagal upload gambar. Coba lagi.'));
        };
    }
})();
</script>
