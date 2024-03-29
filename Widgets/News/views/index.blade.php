@if (!empty($news))
    <div class="news_header d-flex align-items-center mb-2">
        <h3>@t('news.last_news')</h3>

        <a class="watch_all" href="{{ url('/news/') }}">
            @t('news.watch_all')
            <i class="ph ph-arrow-right"></i>
        </a>
    </div>

    <section class="news">
        <div class="news__viewport">
            <div class="news__container">
                @foreach ($news as $new)
                    <article class="news__slide">
                        <a href="{{ url('news/'.$new->slug) }}" class="news__block">
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
                    </article>
                @endforeach
            </div>
        </div>

        <div class="news__controls">
            <div class="news__buttons">
                <button class="news__button news__button--prev" type="button">
                    <svg class="news__button__svg" viewBox="0 0 532 532">
                        <path fill="currentColor"
                            d="M355.66 11.354c13.793-13.805 36.208-13.805 50.001 0 13.785 13.804 13.785 36.238 0 50.034L201.22 266l204.442 204.61c13.785 13.805 13.785 36.239 0 50.044-13.793 13.796-36.208 13.796-50.002 0a5994246.277 5994246.277 0 0 0-229.332-229.454 35.065 35.065 0 0 1-10.326-25.126c0-9.2 3.393-18.26 10.326-25.2C172.192 194.973 332.731 34.31 355.66 11.354Z">
                        </path>
                    </svg>
                </button>

                <button class="news__button news__button--next" type="button">
                    <svg class="news__button__svg" viewBox="0 0 532 532">
                        <path fill="currentColor"
                            d="M176.34 520.646c-13.793 13.805-36.208 13.805-50.001 0-13.785-13.804-13.785-36.238 0-50.034L330.78 266 126.34 61.391c-13.785-13.805-13.785-36.239 0-50.044 13.793-13.796 36.208-13.796 50.002 0 22.928 22.947 206.395 206.507 229.332 229.454a35.065 35.065 0 0 1 10.326 25.126c0 9.2-3.393 18.26-10.326 25.2-45.865 45.901-206.404 206.564-229.332 229.52Z">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </section>
@endif
