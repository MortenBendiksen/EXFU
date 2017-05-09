$('document').ready(function () {
    $("#signup_btn").attr("disabled", "disabled");
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
    function activate_signup_btn() {
        activate = true;
        if ($('#name').css('color') == "rgb(204, 68, 68)" || $('#name').val() == "" || $('label[for=mail]').css('color') != "rgb(255, 255, 255)" || $('#mail').val() == "" || $('#pass1').val() == "" || $('#pass1').val() != $('#pass2').val()) {
            activate = false;
        }
        if (activate) {
            $('#signup_btn').css('background', '#6c6').css('border-color', '#6a6');
            $('#signup_btn').removeAttr('disabled');
        } else {
            $('#signup_btn').css('background', '#c66');
            $("#signup_btn").attr("disabled", "disabled");
        }
    }
    $('#pass1,#pass2').keyup(function () {
        if ($('#pass1').val() != $('#pass2').val()) {
            $('#pass2').css('color', '#c66');
        } else {
            $('#pass2').css('color', '#fff');
        }
        activate_signup_btn();
    });
    $('#securitylevel').change(function () {
        if ($(this).val() != 0) {
            if (window.innerWidth > 700) {
                $('#antikeylog,#antikeyloglabel').show();
            } else {
                $('#antikeylog').show();
            }
        } else {
            $('#antikeylog,#antikeyloglabel').hide();
        }
    });
    $(window).resize(function () {
        if (window.innerWidth > 700) {
            $('#antikeyloglabel').show();
        }else{
            $('#antikeyloglabel').hide();
        }
    });
//******************************** SEND
    $('#name').keyup(function () {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    //NAME TAKEN
                    $('#name').css('color', '#c44');
                } else {
                    //NAME FREE
                    $('#name').css('color', '#6c6');
                }
                activate_signup_btn();
            }
        };
        xhttp.open('POST', 'util/signup.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('cname=' + $(this).val());
    });
    $('#mail').keyup(function () {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                emailPattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/);
                if (xhttp.responseText == 0 || !emailPattern.test($('#mail').val())) {
                    //NAME TAKEN
                    $('#mail,label[for=mail]').css('color', '#c44');
                } else {
                    //NAME FREE
                    $('#mail').css('color', '#6c6');
                    $('label[for=mail]').css('color', '#fff')
                }
                activate_signup_btn();
            }
        };
        xhttp.open('POST', 'util/signup.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('cmail=' + $(this).val());
    });
//******************************** SIGN UP
    $('#signup_btn').click(function () {
        $(this).css('background', '#22f');
        $(this).attr("disabled", "disabled");
        displayname = $('#name').val();
        email = $('#mail').val();
        pass = $('#pass1').val();
        lang = $('#lang').val();
        security = $('#securitylevel').val();
        anti = $('#kln td[n=1]').html() + '' + $('#kln td[n=2]').html() + '' + $('#kln td[n=3]').html();
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    //FAIL TO LOGIN
                    $("#signup_btn").css('background', '#f22');
                    $("#signup_btn").removeAttr('disabled');
                } else {
                    // LOGIN SUCCES
                    $("#signup_btn").css('background', '#2f2');
                    setTimeout(function () {
                        window.location.replace("./login.php");
                    }, 2000);
                }
            }
        };
        xhttp.open('POST', 'util/signup.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('displayname=' + displayname + '&email=' + email + '&password=' + pass + '&language=' + lang + '&securitylevel=' + security + '&antikeylog=' + anti);
    });
});