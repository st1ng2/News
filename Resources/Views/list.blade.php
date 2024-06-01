@extends(tt('layout.blade.php'))

@section('title')
    {{ !empty(page()->title) ? page()->title : t('news.title') }}
@endsection

@push('header')
    @at('Modules/News/Resources/assets/styles/list.scss')
@endpush

@push('content')
    @navbar
    <div class="container">
        @navigation
        @breadcrumb
        @editor

        <div class="news-header">
            <h1>@t('news.all')</h1>

            @can('admin.news')
                <a class="btn btn--with-icon mt-4 outline" href="{{ url('/admin/news/list') }}" role="button">
                    {{ __('def.admin_panel') }}
                    <span class="btn__icon arrow"><i class="ph ph-arrow-right"></i></span>
                </a>
            @endcan
        </div>

        <div class="news">
            @foreach ($news as $new)
                <a href="{{ \Nette\Utils\Validators::isUrl($new->slug) ? $new->slug : url('news/' . $new->slug) }}"
                    class="news__block">
                    <div class="news__block-img">
                        <img src="@at($new->image)" alt="">
                        <div class="gobtn">
                            <i class="ph ph-arrow-up-right"></i>
                        </div>
                    </div>

                    <div class="news__block-content">
                        <div class="new_date">
                            <i class="ph ph-calendar-blank"></i>
                            {{ $service->formatDate($new->created_at) }}
                        </div>

                        <div class="news__block-content-text">
                            <h2>{{ $new->title }}</h2>
                            <p>{{ $new->description }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endpush

@push('footer')
    <script>
        const COUNT_PAGES = {{ $count }};
    </script>
    @at('Modules/News/Resources/assets/js/list.js')
@endpush

@footer
