
@extends('Core.Admin.Http.Views.layout', [
    'title' => __('admin.title', ['name' => __('news.admin.setting')]),
])

@push('header')
@endpush

@push('content')
    <div class="admin-header d-flex justify-content-between align-items-center">
        <div>
            <h2>@t('news.admin.setting')</h2>
            <p>@t('news.admin.setting_description')</p>
        </div>
        <div>
            <a href="{{url('admin/news/add')}}" class="btn size-s outline">
                @t('news.admin.add')
            </a>
        </div>
    </div>

    {!! $table !!}
@endpush
