$(document).ready(() => {
    toggleNavLinks();
    checkIfUserSignIn();
});

// Toggles the active class.
function toggleNavLinks() {
    const navBarBrand = $('.navbar-brand');
    const aTags = $('#navbar-ul > li > a');

    aTags.each(function () {

        let wrapper = $(this).attr('tabindex');
        wrapper = $(`#${wrapper}`);

        if (wrapper.length) {

            aTags.each(function () {
                $(this).addClass('apply-border');
            })

            $(this).addClass('active');
            $(this).parent().addClass('zoomed');

        }

    });

    navBarBrand.click(function () {
        aTags.each(function () {
            $(this).removeClass('active');
            $(this).removeClass('apply-border');
            $(this).parent().removeClass('zoomed');
            $(this).parent().addClass('zoom');
        })
        $('#content-container-wrapper').removeAttr('class')
    });
    
}

function checkIfUserSignIn() {
    if($('#sign-out').length) {            
        $('#start-a-project')
                .removeAttr('data-toggle')
                .removeAttr('data-target')
                .attr('href', 'page/submissions.php');
    }
}       