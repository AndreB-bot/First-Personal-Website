<footer>

</footer>

<div id="overlay">
    <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
        <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
    </svg>
</div>

<div id="sign-up-modal">
    <div class="modal fade" id="sign-up-form-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-form-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <a class="close" data-dismiss="modal" aria-label="Close" href="#"><span aria-hidden="true"><svg class="svg-inline--fa fa-times fa-w-11" aria-hidden="true" data-prefix="fas" data-icon="times" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" data-fa-i2svg=""><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg><!-- <i class="fas fa-times"></i> --></span></a>
            <div class="modal-content modal-sign-up">
                <div class="modal-body">
                    <?php
                    if (!$view) {
                        if ((include '../abertram/html/sign-up-form.html')) {
                            // Do nothing.
                        } else {
                            include '../html/sign-up-form.html';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div id="login-modal">
        <div class="modal fade" id="login-form-modal" tabindex="-1" role="dialog" aria-labelledby="login-form-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <a class="close" data-dismiss="modal" aria-label="Close" href="#"><span aria-hidden="true"><svg class="svg-inline--fa fa-times fa-w-11" aria-hidden="true" data-prefix="fas" data-icon="times" role="presentation" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" data-fa-i2svg=""><path fill="currentColor" d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"></path></svg><!-- <i class="fas fa-times"></i> --></span></a>
                <div class="modal-content">
                    <div class="modal-body">
                        <?php
                        if (!$view) {
                            if ((include '../abertram/html/sign-in-form.html')) {
                                // Do nothing.
                            } else {
                                include '../html/sign-in-form.html';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if ($view) {
    if ($homepage)
        echo '<script src="../abertram/assets/js/signOut.js"></script>';
    else
        echo '<script src="../assets/js/signOut.js"></script>';
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>';
    if ($homepage)
        echo '<script src="../abertram/assets/js/signUpSignIn.js"></script>';
    else
        echo '<script src="../assets/js/signUpSignIn.js"></script>';
}
?>
</div>
</body>
</html>
