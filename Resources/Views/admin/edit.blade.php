@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('news.admin.edit_title')]),
])

@push('content')
    <div class="admin-header d-flex align-items-center">
        <a href="{{ url('admin/news/list') }}" class="back_btn">
            <i class="ph ph-caret-left"></i>
        </a>
        <div>
            <h2>@t('news.admin.edit_title')</h2>
            <p>@t('news.admin.edit_description')</p>
        </div>
    </div>

    <form data-id="{{ $new->id }}" data-newsform="edit" data-page="news">
        @csrf
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="slug">
                    @t('news.admin.slug')
                </label>
            </div>
            <div class="col-sm-9">
                <input name="slug" id="slug" placeholder="@t('news.admin.slug')" type="text" class="form-control"
                    required value="{{ $new->slug }}">
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="title">
                    @t('news.admin.title_label')
                </label>
            </div>
            <div class="col-sm-9">
                <input name="title" id="title" placeholder="@t('news.admin.title_label')" type="text" class="form-control"
                    required value="{{ $new->title }}">
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="description">
                    @t('news.admin.description')
                </label>
            </div>
            <div class="col-sm-9">
                <textarea placeholder="@t('news.admin.description_placeholder')" name="description" id="description"
                    class="form-control">{{ $new->description }}</textarea>
            </div>
        </div>

        <div class="position-relative row form-group align-items-start">
            <div class="col-sm-3 col-form-label required">
                <label>
                    @t('news.admin.content')
                </label>
            </div>
            <div class="col-sm-9">
                <div id="editor"></div>
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label">
                <label for="image">
                    @t('news.admin.image')
                </label>
            </div>
            <div class="col-sm-9">
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>
        </div>

        <!-- Кнопка отправки -->
        <div class="position-relative row form-check">
            <div class="col-sm-9 offset-sm-3">
                <button type="submit" data-save class="btn size-m btn--with-icon primary">
                    @t('def.save')
                    <span class="btn__icon arrow"><i class="ph ph-arrow-right"></i></span>
                </button>
            </div>
        </div>
    </form>
@endpush

@push('footer')
    <script>
        window.editorData = {
            blocks: {!! $new->blocks->json ?? '[]' !!}
        };
    </script>
    <script src="@asset('assets/js/editor/table.js')"></script>
    <script src="@asset('assets/js/editor/alignment.js')"></script>
    <script src="@asset('assets/js/editor/delimiter.js')"></script>
    <script src="@asset('assets/js/editor/embed.js')"></script>
    <script src="@asset('assets/js/editor/header.js')"></script>
    <script src="@asset('assets/js/editor/image.js')"></script>
    <script src="@asset('assets/js/editor/list.js')"></script>
    <script src="@asset('assets/js/editor/marker.js')"></script>

    <script src="@asset('assets/js/editor.js')"></script>

    @at('Core/Admin/Http/Views/assets/js/editor.js')
    @at('Modules/News/Resources/assets/js/admin_form.js')
@endpush
