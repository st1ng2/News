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

        <a href="{{ url('news/') }}" class="btn primary size-s mb-3">
            @t('def.back')
        </a>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="new_container">
                        <div class="new_header">
                            <h1>{{ $new->title }}</h1>
                            <div class="new_header-date">
                                <i class="ph ph-calendar-blank"></i>
                                {{ $service->formatDate($new->created_at) }}
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
