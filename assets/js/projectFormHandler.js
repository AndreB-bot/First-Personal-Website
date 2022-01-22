const icon1 = document.querySelector('#icon1');
const icon2 = document.querySelector('#icon2');
const icon3 = document.querySelector('#icon3');
const icon4 = document.querySelector('#icon4');
const icon5 = document.querySelector('#icon5');


$(document).ready(() => {
    let viewId = {value: 1};

    nextForm(viewId);
    prevForm(viewId);
    doSliderOutput();

    handleChosenSelection();
    handleFormSubmission();
    toggleTextBackground();
});


function doSliderOutput() {
    let slider = document.querySelector(".slider");
    let output = document.querySelector(".output__value");

    output.innerHTML = new Intl.NumberFormat(
            'en-US',
            {style: 'currency', currency: 'USD'}
    ).format(slider.value);

    slider.oninput = function () {
        output.innerHTML = new Intl.NumberFormat(
                'en-US',
                {style: 'currency', currency: 'USD'}
        ).format(this.value);
    };
}

function nextForm(viewId) {
    $('.nxt__btn').each(function () {
        if (this.id !== 'submit-btn') {
            $(this).click((e) => {
                e.preventDefault();


                const hasError = formHasError($(this));

                if (hasError) {
                    return;
                }

                viewId.value++;
                progressBar(viewId.value);
                displayForms(this);
            });
        }
    });
}


function formHasError(el) {
    const related = el.attr('data-related');

    if (related === "chosen-dev-work" || related === "budget") {
        return false;
    }

    let relatedEl = $('#' + related);

    if (!relatedEl[0].checkValidity()) {
        relatedEl[0].reportValidity();
        return true;
    }
    
    return false;
}



function prevForm(viewId) {
    $('.prev__btn').each(function () {
        $(this).click((e) => {
            e.preventDefault();
            viewId.value--;
            progressBar1(viewId.value);
            displayForms(this, 'prev');
        });
    });

}

function displayForms(currentChildElement, direction = 'next') {
    const grandParent = currentChildElement.closest('fieldset');
    grandParent.style.display = 'none';

    if (direction === 'next') {
        $(grandParent).next()[0].style.display = 'grid';
    } else {
        $(grandParent).prev()[0].style.display = 'grid';
}

}

function progressBar1(viewId) {
    if (viewId === 1) {
        icon2.classList.add('active');
        icon2.classList.remove('active');
        icon3.classList.remove('active');
        icon4.classList.remove('active');
        icon5.classList.remove('active');
    }
    if (viewId === 2) {
        icon2.classList.add('active');
        icon3.classList.remove('active');
        icon4.classList.remove('active');
        icon5.classList.remove('active');
    }
    if (viewId === 3) {
        icon3.classList.add('active');
        icon4.classList.remove('active');
        icon5.classList.remove('active');
    }
    if (viewId === 4) {
        icon4.classList.add('active');
        icon5.classList.remove('active');
    }
    if (viewId === 5) {
        icon5.classList.add('active');
    }

}

function progressBar(viewId) {

    if (viewId === 2) {
        icon2.classList.add('active');
    }
    if (viewId === 3) {
        icon3.classList.add('active');
    }
    if (viewId === 4) {
        icon4.classList.add('active');
    }
    if (viewId === 5) {
        icon5.classList.add('active');
    }

}

function handleChosenSelection() {
    $('.selection').each(function () {
        $(this).click(() => {
            $(this).toggleClass('selection-active')
                    .siblings()
                    .removeClass('selection-active');
            $(this).find('input').prop("checked", true);
            $(this).siblings().find('input').prop("checked", false);
        });
    });
}

function toggleTextBackground() {
    const inputs = $('.members input[type=text]');

    inputs.each(function () {
        $(this).change(function () {
            if (this.value) {
                $(this).addClass('value-entered');
                return;
            }
            $(this).removeClass('value-entered');
        });
    });
}

function handleFormSubmission() {
    $('#submit-btn').click((e) => {
        e.preventDefault();

        const mem1 = document.getElementById('member1');
        const pos1 = document.getElementById('position1');
        
        if(!mem1.checkValidity() || !pos1.checkValidity()) {
            mem1.reportValidity();
            pos1.reportValidity();
            return;
        }
        
        $("#overlay").toggleClass('flex');
        const form = document.querySelector("form");
        let fd = new FormData(form);
        
        $.ajax({
            url: '../scripts/projectSubmissions.php',
            method: "POST",
            data: fd,
            contentType: false,
            processData: false
        }).then(res => {
            res = JSON.parse(res);
           
            if (res.status === "SUBMITTED" || res.status === "SUCCESS") {
                setTimeout(() => {
                    location.reload();
                }, 3000);
                
            }
        });

    });
}