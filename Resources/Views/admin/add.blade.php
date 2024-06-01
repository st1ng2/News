@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('news.admin.add_title')]),
])

@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <a class="back-btn" href="{{ url('admin/news/list') }}">
                <i class="ph ph-arrow-left ignore"></i>
                @t('def.back')
            </a>
            <h2>@t('news.admin.add_title')</h2>
            <p>@t('news.admin.add_description')</p>
        </div>
    </div>

    <form data-newsform="add" data-page="news">
        @csrf
        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="slug">
                    @t('news.admin.slug')
                </label>
            </div>
            <div class="col-sm-9">
                <div class="input-group">
                    <div class="input-group-text">{{ app('app.url') }}/news/</div>
                    <input name="slug" id="slug" placeholder="@t('news.admin.slug')" type="text" class="form-control"
                        required>
                </div>
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
                    required>
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="description">
                    @t('news.admin.description')
                </label>
            </div>
            <div class="col-sm-9">
                <textarea placeholder="@t('news.admin.description_placeholder')" name="description" id="description" class="form-control"></textarea>
            </div>
        </div>

        <div class="position-relative row form-group align-items-start">
            <div class="col-sm-3 col-form-label required">
                <label>
                    @t('news.admin.content')
                </label>
            </div>
            <div class="col-sm-9">
                <div data-editorjs id="editorNewsAdd"></div>
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label required">
                <label for="image">
                    @t('news.admin.image')
                </label>
            </div>
            <div class="col-sm-9">
                <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
            </div>
        </div>

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label">
                <label for="published_at">
                    @t('news.admin.published_at')
                </label>
                <small>@t('news.admin.published_at_desc')</small>
            </div>
            <div class="col-sm-9">
                <input name="published_at" id="published_at" placeholder="@t('news.admin.published_at_placeholder')" type="datetime-local"
                    class="form-control">
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
    <script src="@asset('assets/js/editor/table.js')"></script>
    <script src="@asset('assets/js/editor/alignment.js')"></script>
    <script src="@asset('assets/js/editor/delimiter.js')"></script>
    <script src="@asset('assets/js/editor/raw.js')"></script>
    <script src="@asset('assets/js/editor/embed.js')"></script>
    <script src="@asset('assets/js/editor/header.js')"></script>
    <script src="@asset('assets/js/editor/image.js')"></script>
    <script src="@asset('assets/js/editor/list.js')"></script>
    <script src="@asset('assets/js/editor/marker.js')"></script>

    <script src="@asset('assets/js/editor.js')"></script>

    @at('Core/Admin/Http/Views/assets/js/editor.js')
    @at('Modules/News/Resources/assets/js/admin_form.js')
@endpush
