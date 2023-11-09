let offset = 0;
const sliderLine = document.querySelector('.slider-line');

document.querySelector('.slider-prev').addEventListener('click', function() {
    offset -= 570;
    if (offset < 0)
        offset = 0;

    sliderLine.style.left = -offset + 'px';
});

document.querySelector('.slider-next').addEventListener('click', function() {
    offset += 570;
    if (offset > 1140)
        offset = 1140;

    sliderLine.style.left = -offset + 'px';
});

document.querySelector('.indicator').addEventListener('click', function() {
    offset += 310;
    if (offset > 620)
        offset = 0;

    sliderLine.style.left = -offset + 'px';
});



const logoUpBtn = document.querySelector('.logo');

logoUpBtn.addEventListener('click', goTop);

function goTop() {
    if (window.scrollY  > 0) {
        window.scrollBy(0, -75);
        setTimeout(goTop, 0);
    }
}

document.querySelector('.link order-ref').button.addEventListener('click', (e) => {
    e.preventDefault();
});