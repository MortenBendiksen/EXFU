$('document').ready(function () {
    $('#logout_btn').click(function () {
        $("#logout_confirm").toggle();
        if ($("#logout_confirm").css('display') == "none") {
            $(this).css('background', '#0c0');
        } else {
            $(this).css('background', '#a11');
        }
    });
    $('#menu_btn').click(function () {
        $('menu a').toggle();
        $("#logout_confirm").hide();
    });
    $('#menu_light').click(function () {
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
    function rotatePlanets() {
        $('solarsystems planet').each(function () {
            var rotation = (parseInt($(this).attr('rotation')) * (Date.now() / 100000 % 360));
            $(this).transition({rotate: rotation + 'deg'}, 0);
            $(this).children('div').transition({rotate: -rotation + 'deg'}, 0);
        });
    }

    function mapLoad(parameters, mapAnimation) {
        url = 'map.php' + parameters;
        $.ajax({
            url: url,
            success: function (data) {
                $('#map').html(data);
                rotatePlanets();
                $('#map').show().css('bottom', ($(window).height() - 50) + "px").transition({bottom: "0px"}, mapAnimation * 2);
                $('#map_btn').blur();
                rotateAnimation = setInterval(function () {
                    rotatePlanets();
                }, 1000);
            }
        });
    }

    $('#map_btn').click(function () {
        var btn = $(this);
        var mapAnimation = 500;
        if ($('#map').css('display') === 'none') {
            mapLoad('', mapAnimation);
        } else {
            clearInterval(rotateAnimation);
            $('#map').transition({bottom: ($(window).height() - 50) + "px"}, mapAnimation);
            setTimeout(function () {
                $('#map').hide();
            }, mapAnimation);
            btn.blur();
        }
    });
    $('#map').on('click', 'galaxies solarsystem', function () {
        mapLoad('?solarsystem=' + $(this).attr('ss'), 0);
    }).on('click', 'solarsystems planet div', function () {
        mapLoad('?planet=' + $(this).parent().attr('pp'), 0);
    }).on("contextmenu", "solarsystems", function (e) {
        e.preventDefault();
        mapLoad('?galaxy=' + $(this).attr('parent'), 0);
    }).on("contextmenu", "planets", function (e) {
        e.preventDefault();
        mapLoad('?solarsystem=' + $(this).attr('parent'), 0);
    });
    $(window).resize(function () {
        //$('#test').html(window.innerWidth);
        $('#content #role div').css('line-height', $('#content #role div').height() + 'px');
        if (window.innerWidth > 700) {
            $('menu a').show();
            $("#logout_confirm").hide();
        } else {
            $('menu a').hide();
        }
    });
//-------------------------------- SHIP
    $('.ship_btn').mouseover(function () {
        $('#ship').attr('highlight',$(this).attr('name'));
    }).mouseleave(function(){
        $('#ship').removeAttr('highlight');
    });
//-------------------------------- INDEX
    $('#new').click(function () {
        document.location.href = 'creategroup.php';
    });
    $('.group:not([id="new"])').click(function () {
        if ($(this).children('button').css('width') === "0px") {
            $(this).children('button').transition({width: '20%'}, 500).parent().siblings().children('button').transition({width: '0%'}, 500);
        }
    });
    $('.group button').click(function () {
        group = $(this).parent().attr('group');
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 1) {
                    //Group saved
                    window.location.reload();
                } else {
                    //Error
                    alert(xhttp.responseText);
                }
            }
        };
        xhttp.open('POST', '/util/selectgroup.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("group=" + group);
    });
//-------------------------------- CREATE GROUP
    $('#content #role #role_tank,#content #role #role_supp,#content #role #role_heal,#content #role #role_cont,#content #role #role_dama').click(function () {
        $("#selected_role").val($(this).attr('id'));
        $("#role button").removeAttr('disabled');
        $("#role #desc div").hide();
        $("#role #desc div[class='" + $(this).attr('id') + "']").show();
        $("#role div").removeClass('active');
        $(this).addClass('active');
    });
    $("#role button").click(function () {
        selected = $("#selected_role").val();
        $("#content #role #role_tank,#content #role #role_supp,#content #role #role_heal,#content #role #role_cont,#content #role #role_dama,#content #role #desc").hide();
        $("#content #role #" + selected).css('margin-left', '40%').show().transition({'line-height': '50px', 'height': '50px', 'width': '100%', 'margin-left': "0%"}, 1500);
        $('#role button').attr('disabled', "1");
        setTimeout(function () {
            window.location.href = "?role=" + selected;
        }, 1500);
    });
    c = 0;
    $('#powerset #power').click(function () {
        if ($(this).attr('element') != null) {
            if ($(this).parent().attr('class') === "main") {
                $('#powerset .main #power').removeClass('active');
                $('#main_powerset').val($(this).attr('name'));
            } else {
                $('#powerset .secondary #power').removeClass('active');
                $('#secondary_powerset').val($(this).attr('name'));
            }
            if (c < 1) {
                $('.main div').transition({opacity: '.1'}, 500).css('pointer-events', 'none');
                $('.secondary div').transition({opacity: '1'}, 500).css('pointer-events', 'auto');
                $('#powerset #mainpowersetheader').transition({opacity: '0'}, 250).hide(250);
                $('#powerset #secondarypowersetheader').transition({opacity: '0'}, 0).delay(250).show(250).transition({opacity: '1'}, 250);

            } else if (c < 2) {
                $('.main div').transition({opacity: '1'}, 500).css('pointer-events', 'auto');
                $('#powerset #secondarypowersetheader').transition({opacity: '0'}, 250).hide(250);
                $('#powerset #changepowersetheader').transition({opacity: '0'}, 0).delay(250).show(250).transition({opacity: '1'}, 250);
            }
            $(this).addClass('active');
            if ($('#main_powerset').val() !== "" && $('#secondary_powerset').val() !== "") {
                $('#powerset button').removeAttr('disabled');
            }
            c++;
        }
    });
    $('#powerset button').click(function () {
        if ($('#main_powerset').val() != "" && $('#secondary_powerset').val() != "") {
            if ($('#char_name').val() == "") {
                $('#powerset button').css('visibility', 'hidden').attr('disabled', '1');
                $('#powersets,#powerset h3').hide();
                $('#powerset #powersetheader').hide();
                $('#powerset #charnameheader').show();
                $('#powerset input[class="active selected"]').val('').removeAttr('disabled').focus();

            } else {
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (xhttp.readyState == 4 && xhttp.status == 200) {
                        if (xhttp.responseText == 0) {
                            //ERROR
                            alert('Error: Try again later');
                        } else {
                            //GROUP CREATED
                            window.location.href = "/game";
                        }
                    }
                };
                xhttp.open('POST', '/util/creategroup.php', true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send('groupname=TEST&name=' + $('#char_name').val() + '&role=' + $('#role_selected').val() + '&mainpower=' + $('#main_powerset').val() + '&secondarypower=' + $('#secondary_powerset').val());
            }
        }
    });
    $('#powerset input[class="active selected"]').keyup(function () {
        $('#char_name').val($(this).val());
        if ($(this).val() != "") {
            $('#powerset button').css('visibility', 'visible').removeAttr('disabled');
        } else {
            $('#powerset button').css('visibility', 'hidden').attr('disabled', '1');
        }
    }).focusout(function () {
        $(this).focus()
    });
/////// END OF READY
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