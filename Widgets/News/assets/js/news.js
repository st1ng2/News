const addTogglePrevNextBtnsActiveForNews = (carouselApi, prevButton, nextButton) => {
    const togglePrevNextBtnsState = () => {
        if (carouselApi.canScrollPrev()) prevButton.removeAttribute('disabled');
        else prevButton.setAttribute('disabled', 'disabled');

        if (carouselApi.canScrollNext()) nextButton.removeAttribute('disabled');
        else nextButton.setAttribute('disabled', 'disabled');
    };

    carouselApi
        .on('select', togglePrevNextBtnsState)
        .on('init', togglePrevNextBtnsState)
        .on('reInit', togglePrevNextBtnsState);

    return () => {
        prevButton.removeAttribute('disabled');
        nextButton.removeAttribute('disabled');
    };
};

const addPrevNextBtnsClickHandlersForNews = (carouselApi, prevButton, nextButton) => {
    const scrollPrev = () => {
        carouselApi.scrollPrev();
    };
    const scrollNext = () => {
        carouselApi.scrollNext();
    };
    prevButton.addEventListener('click', scrollPrev, false);
    nextButton.addEventListener('click', scrollNext, false);

    const removeTogglePrevNextBtnsActive = addTogglePrevNextBtnsActiveForNews(
        carouselApi,
        prevButton,
        nextButton,
    );

    return () => {
        removeTogglePrevNextBtnsActive();
        prevButton.removeEventListener('click', scrollPrev, false);
        nextButton.removeEventListener('click', scrollNext, false);
    };
};

const NEWS_OPTIONS = { align: 'start' };

const newsNode = document.querySelector('.news');
const newsViewportNode = newsNode.querySelector('.news__viewport');
const newsPrevButtonNode = newsNode.querySelector('.news__button--prev');
const newsNextButtonNode = newsNode.querySelector('.news__button--next');

const carouselApi = EmblaCarousel(newsViewportNode, NEWS_OPTIONS);

const removePrevNextBtnsClickHandlers = addPrevNextBtnsClickHandlersForNews(
    carouselApi,
    newsPrevButtonNode,
    newsNextButtonNode,
);

carouselApi.on('destroy', removePrevNextBtnsClickHandlers);
