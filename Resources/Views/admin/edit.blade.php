@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('news.admin.edit_title')]),
])

@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <a class="back-btn" href="{{ url('admin/news/list') }}">
                <i class="ph ph-arrow-left ignore"></i>
                @t('def.back')
            </a>
            <h2>@t('news.admin.edit_title')</h2>
            <p>@t('news.admin.edit_description')</p>
        </div>
        <div>
            <button data-deleteaction="{{ $new->id }}" data-deletepath="news" class="btn size-s error outline">
                @t('def.delete')
            </button>
            <a href="{{ url('news/' . $new->slug) }}" class="btn btn--with-icon size-s ignore outline" target="_blank">
                @t('def.goto')
                <span class="btn__icon arrow"><i class="ph ph-arrow-right"></i></span>
            </a>
        </div>
    </div>

    @if ($new->published_at && $new->published_at > now())
        <div class="admin-notification mb-4">
            <div class="admin-notification-content">
                <i class="ph ph-warning-circle"></i>
                <div>
                    <h4>@t('def.warning')!</h4>
                    <p>@t('news.admin.new_is_not_published', [
                        ':date' => $new->published_at->format(default_date_format()),
                    ])</p>
                </div>
            </div>
        </div>
    @endif

    <form data-id="{{ $new->id }}" data-newsform="edit" data-page="news">
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
                        required value="{{ $new->slug }}">
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
                <textarea placeholder="@t('news.admin.description_placeholder')" name="description" id="description" class="form-control">{{ $new->description }}</textarea>
            </div>
        </div>

        <div class="position-relative row form-group align-items-start">
            <div class="col-sm-3 col-form-label required">
                <label>
                    @t('news.admin.content')
                </label>
            </div>
            <div class="col-sm-9">
                <div data-editorjs id="editorNewsEdit-{{ $new->id }}"></div>
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

        <div class="position-relative row form-group">
            <div class="col-sm-3 col-form-label">
                <label for="published_at">
                    @t('news.admin.published_at')
                </label>
            </div>
            <div class="col-sm-9">
                <input name="published_at" id="published_at" placeholder="@t('news.admin.published_at_placeholder')" type="datetime-local"
                    class="form-control"
                    @if ($new->published_at) value="{{ $new->published_at->format('Y-m-d\TH:i:s') }}" @endif
                    max="2099-12-23T19:37:29">
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
    <script data-loadevery>
        window.defaultEditorData["editorNewsEdit-{{ $new->id }}"] = {
            blocks: {!! $new->blocks->json ?? '[]' !!}
        };
    </script>
    <script src="@asset('assets/js/editor/table.js')"></script>
    <script src="@asset('assets/js/editor/alignment.js')"></script>
    <script src="@asset('assets/js/editor/delimiter.js')"></script>
    <script src="@asset('assets/js/editor/embed.js')"></script>
    <script src="@asset('assets/js/editor/raw.js')"></script>
    <script src="@asset('assets/js/editor/header.js')"></script>
    <script src="@asset('assets/js/editor/image.js')"></script>
    <script src="@asset('assets/js/editor/list.js')"></script>
    <script src="@asset('assets/js/editor/marker.js')"></script>

    <script src="@asset('assets/js/editor.js')"></script>

    @at('Core/Admin/Http/Views/assets/js/editor.js')
    @at('Modules/News/Resources/assets/js/admin_form.js')
@endpush
