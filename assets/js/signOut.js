$(document).ready(() => {
    handleSignOut();
});

function handleSignOut() {

    $('#sign-out').click(() => {
        $("#overlay").toggleClass('flex');
        
        let loc = '../index.php', url = '../scripts/signOut.php';
        
        if(location.href.includes('index')) {
            loc = 'index.php';
            url = "../abertram/scripts/signOut.php";
        }
        
        $.ajax({
            method : "POST",
            url: url,
            data: {
                "sign_out" : "true"
            }
        }).then(res => {
            if(res === "success") {
                setTimeout(() => {
                  location.href = loc;  
                }, 3000);                
            }
        });
    });
}
