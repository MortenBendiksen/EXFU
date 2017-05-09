$('document').ready(function () {
    $('#menu_btn').click(function () {
        $('menu a').toggle();
    });
    $('#menu_light').click(function () {
        if ($('#overlay').css('opacity') == 0) {
        } else {
        }
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    //LIGHTS OUT
                    $('#overlay').transition({opacity: .8});
                    $('#footerbottom').transition({'background-color': '#000'});
                    $('#menu_light').css('color', '#000');
                } else {
                    //LIGHTS ON
                    $('#overlay').transition({opacity: 0});
                    $('#footerbottom').transition({'background-color': '#488'});
                    $('#menu_light').css('color', '#fff');
                }
            }
        };
        xhttp.open('POST', '/util/light.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send();
    });
    $(window).resize(function () {
        $('#test').html(window.innerWidth);
        if (window.innerWidth > 700) {
            $('menu a').show();
        } else {
            $('menu a').hide();
        }
    });
    $('input[type=password').focusout(function () {
        $(this).attr('type', 'password');
    }).focusin(function () {
        $(this).attr('type', 'text');
    });
    $('#start').click(function () {
        document.body.style.overflow = 'hidden';
        $('header,menu,#content').transition({y: -50}, 500, 'ease');
        $('menu a').hide();
        $('#content').html('<div id="loadGame"><div></div></div><div id="counterGame"></div>').transition({'min-height': window.innerHeight}, 500, 'snap').css('margin', '0');
        loadBarMax = 0;
        redirect = "";
        goRed = false;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    loadBarMax = 75;
                    redirect = "/?not_logged_in=1";
                    goRed = true;
                } else {
                    loadBarMax = 100;
                    redirect = "/game";
                }
            }
        };
        xhttp.open('POST', '/util/logincheck.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send();
        setTimeout(function () {
            progress = 0;
            $("#loadGame").show().height(window.innerHeight / 10).width('80%').css('margin-left', '10%').css('margin-top', (window.innerHeight / 2) - (window.innerHeight / 15));
            progression = setInterval(function () {
                $('#loadGame div').transition({'min-width': progress + '%'}, 20, 'ease');
                $('#counterGame').html(progress + "%");
                if (progress >= loadBarMax) {
                    clearInterval(progression);
                    if (goRed) {
                        $('#loadGame div').css('background', '#f22');
                    }
                    setTimeout(function () {
                        window.location.replace(redirect);
                    }, 1000);
                } else {
                    progress = progress + 2;
                }
            }, 20);
        }, 800);

    });
});
function rand(e, f) {
    if (e === undefined && f === undefined) {
        e = 0;
        f = 100;
    }
    if (f === undefined) {
        f = e;
        e = 0;
    }
    return Math.floor(Math.random() * (f - e + 1) + e);
}