$(document).ready(() => {
    //usernameAndPasswordTooltip();
    signUpSubmission();
    promptAlreadyTaken();
    clearForm();
    signInSubmission();
    handleVerificationSubmission();

});

function signUpSubmission() {

    const submit = $('#sign-up-submit-btn');

    submit.click(function (e) {
        e.preventDefault();
        const form = $('#sign-up-form');
        emailFormatted = true;

        let values = form.find('input').filter(function () {
            return this.checkValidity() === false;
        });

        if (!$('div.active-invalid-feedback').length && !values.length) {

            let loaderDiv = loadLoaderDiv();
            let modalContent = $('#sign-up-modal .modal-content');
            let close = $('#sign-up-modal .close');

            const url = getUrl();

            $.ajax({
                method: "POST",
                url: url,
                data: form.serialize()
            }).then(res => {

                res = JSON.parse(res);

                let containerDiv = document.createElement("div");
                let msgDiv = document.createElement("div");
                let msg1 = document.createElement("p");


                containerDiv.classList.add("thank-you-div");

                msg1.innerText = res.message;

                msgDiv.appendChild(msg1);
                msgDiv.classList.add('msgDiv');

                containerDiv.appendChild(msgDiv);

                setTimeout(function () {
                    $('.loader-div').replaceWith(containerDiv);
                    modalContent.toggleClass('clp-none');
                    close.show();
                    confetti({zIndex: 1050, particleCount: 200, spread: 90});
                }, 3000);


            });

            modalContent.toggleClass('clp-none');
            close.hide();

            form.replaceWith(loaderDiv);
            reloadOnModalClose();
        } else {
            document.forms['sign-up-form'].reportValidity();
        }
    });

}

function loadLoaderDiv() {
    let src = "../css/imgs/ajax-loader.gif";
    
    if(getUrl().includes('abertram')) {
        src = "../abertram/css/imgs/ajax-loader.gif"
    }
    
    let loader = document.createElement("img");
    loader.src = src;
    loader.classList.add("loader");

    let loaderDiv = document.createElement("div");
    loaderDiv.classList.add("loader-div");

    loaderDiv.append(loader);

    return loaderDiv;
}

function usernameAndPasswordTooltip() {
    $('#username').tooltip();
    $('#password').tooltip();
}

function clearForm() {
    $('.modal').on('hidden.bs.modal', () => {
        $('form').each(function () {
            this.reset();
            $(this).find('.invalid-input').each(function () {
                this.classList.remove('invalid-input');
            });
            $(this).find('.active-invalid-feedback').each(function () {
                this.classList.remove('active-invalid-feedback');
            });
        });
    });
}

function reloadOnModalClose() {
    $('.modal').on('hidden.bs.modal', () => {
        location.reload();
    });
}

function promptAlreadyTaken() {
    const targetedInputs = [$('#username'), $('#company_name'), $('#email')];

    targetedInputs.forEach((element) => {
        let typingTimer;
        let doneTypingInterval = 500;

        element.keyup(function () {
            clearTimeout(typingTimer);
            let value = $(this).val();

            if (value) {

                const url = getUrl();

                typingTimer = setTimeout(() => {
                    let id = $(this).attr('id');

                    $.ajax({
                        method: "POST",
                        url: url,
                        data: {
                            id: id,
                            value: value
                        }
                    }).then(res => {
                        if (res === "true") {
                            $(this).addClass('invalid-input');

                            if (id === "email") {
                                $(this).parent().next().toggleClass('active-invalid-feedback');
                            } else if (id === "username") {

                                $(this).next().next().addClass('active-invalid-feedback');
                            } else {
                                $(this).next().addClass('active-invalid-feedback');
                            }
                        } else {
                            $(this).removeClass('invalid-input');

                            if (id === "email") {
                                $(this).parent().next().removeClass('active-invalid-feedback');
                            } else if (id === "username") {
                                $(this).next().next().removeClass('active-invalid-feedback');
                            } else {
                                $(this).next().removeClass('active-invalid-feedback');
                            }
                        }
                    });

                }, doneTypingInterval);
            }

        });
    });
}

function signInSubmission() {
    const submit = $('#sign-in-form-btn');

    submit.click(function (e) {
        e.preventDefault();

        const form = $('#sign-in-form');
        let modal = $('#login-modal .modal-content');
        let closeTag = $('#login-modal .close');
        let modalBody = $('#login-modal .modal-body')[0];

        let values = form.find('input').filter(function () {
            return this.value === "";
        });


        if (!values.length) {

            const url = getUrl();
            let file = '../html/validationForm.html';
            
            if(url.includes('abertram')) {
                file = '../abertram/html/validationForm.html';
            }
            
            let response;

            $.when(
                    $.ajax({
                        method: "POST",
                        url: url,
                        data: form.serialize()
                    }).then(res => {
                response = JSON.parse(res);

            })
                    )
                    .done(function () {

                        if (response.hasOwnProperty('hasErrors')) {
                            $(".form-has-errors").show();

                        } else {
                            modal.toggleClass('clp-none');
                            closeTag.hide();

                            let loaderDiv = loadLoaderDiv();
                            form.replaceWith(loaderDiv);

                            if (response.hasOwnProperty('validated')) {
                                setTimeout(() => {
                                    location.reload();
                                }, 4000);
                            }

                            if (response.hasOwnProperty('notValidated')) {
                                //mutationWatcher(modalBody);

                                setTimeout(() => {
                                    let varDiv = document.createElement("div");
                                    $(varDiv).load(file);
                                    $('#login-modal .modal-dialog').addClass("t-pr");

                                    modal.toggleClass('clp-none');
                                    closeTag.show();
                                    $(loaderDiv).replaceWith(varDiv);

                                }, 2000);

                            }

                        }
                        reloadOnModalClose();
                    });

        } else {
            document.forms['sign-in-form'].reportValidity();
        }
    });
}

function getUrl() {
    let url = "../scripts/signUpSignIn.php";

    if (location.href.includes('index')) {
        url = "../abertram/scripts/signUpSignIn.php";
    }
    return url;
}

function handleVerificationSubmission() {

    $(document).on('click', '#validation-form-btn', function (e) {
        e.preventDefault();

        const input = document.getElementById('verification-code');

        if (input.value === "") {
            input.setCustomValidity('This field is required.');
            input.reportValidity();
            return;
        }

        const form = $(document.forms['validation-form']);

        let url = getUrl();

        $.ajax({
            method: "POST",
            url: url,
            data: form.serialize()
        }).then(res => {
            if (res === "true") {
                location.reload();
            } else {
                alert("Invalid verification code");
            }
        });
    });
}

// Not used.
function mutationWatcher($target) {
    // Create an observer instance
    let observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            let newNodes = mutation.addedNodes; // DOM NodeList

            if (newNodes.length) { // If there are new nodes added
                let $nodes = $(newNodes); // jQuery set
                $nodes.each(function () {
                    let node = $(this);
                    node = $(node).find("#validation-form-btn");

                    if (node.id === "validation-form-btn") {

                    }
                });
            }
        });
    });

// Configuration of the observer:
    let config = {
        attributes: true,
        childList: true,
        characterData: true
    };

// Pass in the target node, as well as the observer options
    observer.observe($target, config);

    return observer;
}