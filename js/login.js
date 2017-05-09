$('document').ready(function () {
    $('#kln td[n=1]').html(rand(0, 9));
    $('#kln td[n=2]').html(rand(0, 9));
    $('#kln td[n=3]').html(rand(0, 9));
    $('#klu button,#kld button').click(function () {
        num = $(this).attr('n');
        oldNum = parseInt($('#kln td[n=' + num + ']').html());
        if ($(this).parent().parent().attr('id') === 'klu') {
            oldNum++;
        } else {
            oldNum--;
        }
        if (oldNum < 0) {
            oldNum = 9;
        }
        if (oldNum > 9) {
            oldNum = 0;
        }
        $('#kln td[n=' + num + ']').html(oldNum);
    });
    $('#antikeylog button,#antikeylog td').bind('mousewheel', function (e) {
        e.preventDefault();
        c = parseInt($('#kln td[n=' + $(this).attr('n') + ']').html());
        if (e.originalEvent.wheelDelta > 0) {
            c++;
        } else {
            c--;
        }
        if (c < 0) {
            c = 9;
        }
        if (c > 9) {
            c = 0;
        }
        $('#kln td[n=' + $(this).attr('n') + ']').html(c);
    });
    $('#login_btn').click(function () {
        $(this).css('background', '#22f');
        $(this).attr("disabled","disabled");
        user = $('#email').val();
        pass = $('#password').val();
        anti = $('#kln td[n=1]').html() + '' + $('#kln td[n=2]').html() + '' + $('#kln td[n=3]').html();
        $('#kln td[n=1]').html(rand(0, 9));
        $('#kln td[n=2]').html(rand(0, 9));
        $('#kln td[n=3]').html(rand(0, 9));
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    //FAIL TO LOGIN
                    $("#login_btn").css('background', '#f22');
                    $("#login_btn").removeAttr('disabled');
                } else {
                    // LOGIN SUCCES
                    $("#login_btn").css('background', '#2f2');
                    setTimeout(function () {
                        window.location.replace("../");
                    }, 2000);
                }
            }
        };
        xhttp.open('POST', 'util/login.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('u=' + user + '&p=' + pass + '&a=' + anti);
    });
});