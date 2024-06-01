@extends(tt('layout.blade.php'))

@section('title')
    {{ !empty(page()->title)
        ? page()->title
        : t('news.new_title', [
            ':name' => $new->title,
        ]) }}
@endsection

@push('header')
    @at('Modules/News/Resources/assets/styles/new.scss')
@endpush

@push('content')
    @navbar
    <div class="container">
        @navigation
        @breadcrumb
        @flash

        @if ($new->published_at && now() < $new->published_at)
            <div class="alert alert-info">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <circle cx="12" cy="12" r="9" />
                    <line x1="12" y1="16" x2="12" y2="12" />
                    <line x1="12" y1="8" x2="12.01" y2="8" />
                </svg>
                <div>
                    @t('news.admin.new_is_not_published', [
                        ':date' => $new->published_at->format(default_date_format()),
                    ])
                </div>
            </div>
        @endif

        <div class="new-header mb-3">
            <a href="{{ url('news/') }}" class="btn primary size-s">
                @t('def.back')
            </a>

            @can('admin.news')
                <a href="{{ url('admin/news/edit/' . $new->id) }}" class="btn btn--with-icon size-s outline">
                    @t('def.edit')
                    <span class="btn__icon arrow"><i class="ph ph-arrow-right"></i></span>
                </a>
            @endcan
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="new_container">
                        <div class="new_header">
                            <h1>{{ $new->title }}</h1>
                            <div class="new_header-contents">
                                <div class="new_header-date">
                                    <i class="ph ph-calendar-blank"></i>
                                    {{ $service->formatDate($new->created_at) }}
                                </div>
                                <div class="new_header-views">
                                    <i class="ph ph-eye"></i>
                                    {{ $new->views }} @t('news.views')
                                </div>
                            </div>
                        </div>

                        <div class="new_content">
                            <div class="new_content-short">
                                <img src="@at($new->image)" alt="{{ $new->title }}">

                                <h3>{{ $new->description }}</h3>
                            </div>

                            <div class="new_content-full">
                                <div class="mb-4">
                                    {!! $editor !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('footer')
@endpush

@footer
