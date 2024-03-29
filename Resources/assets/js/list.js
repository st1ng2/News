// Функция для форматирования даты в заданном формате
function formatDate(date, lang) {
    const monthsRu = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря',
    ];
    const monthsEn = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];
    const months = lang === 'ru' ? monthsRu : monthsEn;

    const formattedDate = `${date.getDate()} ${
        months[date.getMonth()]
    }, ${date.getFullYear()} ${('0' + date.getHours()).slice(-2)}:${(
        '0' + date.getMinutes()
    ).slice(-2)}`;
    return formattedDate;
}

$(document).ready(function () {
    let currentPage = 2;

    // Function to load news
    function loadNews(page) {
        if (currentPage > COUNT_PAGES) return;

        $.ajax({
            url: u('news/get'),
            type: 'GET',
            data: { page: page },
            beforeSend: function () {
                if (page > 1) {
                    $('.news').append('<div class="loading">Loading...</div>');
                }
            },
            success: function (response) {
                if (page > 1) {
                    $('.loading').remove();
                }
                response.forEach(function (newsItem) {
                    let newsDate = new Date(newsItem.created_at.date);
                    let formattedDate = formatDate(
                        newsDate,
                        $('html').attr('lang'),
                    );

                    let newsHtml =
                        '<a href="' +
                        u(`news/${newsItem.slug}`) +
                        '" class="news__block">' +
                        '<div class="news__block-img">' +
                        '<img src="' +
                        newsItem.image +
                        '" alt="">' +
                        '<div class="gobtn"><i class="ph ph-arrow-up-right"></i></div>' +
                        '</div>' +
                        '<div class="news__block-content">' +
                        '<div class="new_date"><i class="ph ph-calendar-blank"></i>' +
                        formattedDate +
                        '</div>' +
                        '<div class="news__block-content-text">' +
                        '<h2>' +
                        newsItem.title +
                        '</h2>' +
                        '<p>' +
                        newsItem.description +
                        '</p>' +
                        '</div>' +
                        '</div>' +
                        '</a>';
                    $('.news').append(newsHtml);
                });
                currentPage++;
            },
            error: function () {
                alert('Error loading news');
            },
        });
    }

    // Infinite scroll
    $(window).scroll(function () {
        if (
            $(window).scrollTop() + $(window).height() >=
            $(document).height()
        ) {
            loadNews(currentPage);
        }
    });
});
