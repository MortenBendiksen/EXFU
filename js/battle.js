$('document').ready(function () {
    var currentTurn = {'type': '', 'id': {'turn': 99999999999}};
    var characters = [];
    var enemies = [];
    var powers = [];
    var actions = [];
    var currentTarget = 0;
    var speed = 3500;
    var attackSpeed = speed;
    var pointerAction = parseInt($('pointerAction').attr('start'));
    var pointerActionPos = pointerAction;
    var posP = [];
    var posE = [];
    var win = 0;
    $('turns, power').hide();
    // XML indlæses
    $.ajax({
        type: "GET",
        url: "/util/battle.php?battle=" + $('battle').attr('id'),
        dataType: "xml",
        success: function (xml) {
            // Spillet bygges med data fra arrays
            buildGame(xml);
            loadActions();
            setThreadPriority();
        }
    });
    /* --  LISTENERS  ------------------------------------------------------- */
    $('battlegroup, enemygroup').on('click', 'character,enemy', function () {
        setTarget($(this));
    });
    $('powers').on('click', 'power', function () {
        if (currentTarget !== 0) {
            attack(parseInt($(this).attr('id')), currentTarget, 100);
            $('position').css('visibility', 'hidden');
            $('power').hide();
        } else {
            msg('NO_TARGET');
        }
    });
    $('battle').click(function (e) {
        var x = Math.ceil(((e.pageX - $(this).offset().left) / $(this).width() * 100) / 5 - 1);
        var y = Math.ceil(((e.pageY - $(this).offset().top) / $(this).height() * 100) / 6.25 - 1);
        var id = $("charactermodel[x='" + x + "'][y='" + y + "'],enemymodel[x='" + x + "'][y='" + y + "']").attr('id');
        if (id !== undefined) {
            setTarget($("character[id='" + id + "'],enemy[id='" + id + "']"));
        }
    });
    $('battle').on('click', 'position', function () {
        id = $('character[active=1]').attr('id');
        x = parseInt($(this).attr('x'));
        y = parseInt($(this).attr('y'));
        ax = parseInt($("charactermodel[id='" + id + "']").attr('x')) - x;
        ay = parseInt($("charactermodel[id='" + id + "']").attr('y')) - y;
        spotTaken = $("charactermodel[x='" + x + "'][y='" + y + "'],enemymodel[x='" + x + "'][y='" + y + "']").attr('id');
        if ((ax === -1 || ax === 0 || ax === 1) && (ay === -1 || ay === 0 || ay === 1) && !(ax === 0 && ay === 0) && spotTaken === undefined) {
            moveUnit(id, x, y);
            $('position').css('visibility', 'hidden');
        }
    });
    $('battle').on('click', 'end button', function () {
        endGame(win);
    });
    /* --  /LISTENERS  ------------------------------------------------------ */
    function msg(e) {
        $('error').remove();
        $('battle').append('<error>' + e + '</error>');
        setTimeout(function () {
            $('error').remove();
        }, speed);
    }
    function setTarget(unit) {
        currentTarget = unit.attr('id');
        $('character,enemy').removeAttr('currenttarget');
        unit.attr('currenttarget', 1);
    }
    function setUnitPos(type, id, x, y) {
        moveUnit(type + id, x, y, 0);
    }
    function moveUnit(id, x, y, moveSpeed) {
        if (moveSpeed === undefined) {
            moveSpeed = speed / 2;
        }
        $("charactermodel[id='" + id + "'],enemymodel[id='" + id + "']").transition({'top': (6.25 * (y - 1) - 1) + '%', 'left': (5 * x + 0.5) + '%'}, moveSpeed).css('z-index', y);
        setTimeout(function () {
            $("charactermodel[id='" + id + "'],enemymodel[id='" + id + "']").attr('x', x).attr('y', y);
        }, moveSpeed);
    }

    $('#skip').click(function () {
        window.location.replace('?id=' + $('battle').attr('id') + '&start=' + actions.length);
    });

    function buildArrays(xml) {
        var xmlDoc = $.parseXML(xml), $xml = $(xmlDoc);
        // Positioner læses
        $(xml).find("battle").each(function () {
            posP = [[1, 4], [4, 4], [2, 6], [4, 6], [2, 10]];
            posE = [[8, 5], [14, 4], [12, 6], [14, 6], [12, 10]];
        });
        // Characters puttes i et array
        $(xml).find("character").each(function () {
            id = parseInt($(this).attr('id'));
            primarypowerset = parseInt($(this).attr('primarypowerset'));
            secondarypowerset = parseInt($(this).attr('secondarypowerset'));
            talents = parseInt($(this).attr('talents'));
            powerlevel = parseInt($(this).attr('powerlevel'));
            haspower = [];
            role = parseInt($(this).attr('role'));
            thread = (5 - role) * 5;
            hp = (((11 - role) / 10) * powerlevel);
            name = $(this).attr('name');
            $(xml).find("character[id='" + id + "'] power").each(function () {
                haspower.push(parseInt($(this).attr('id')));
            });
            characters.push({'id': id, 'actortype': 'p', 'primarypowerset': primarypowerset, 'secondarypowerset': secondarypowerset, 'talents': talents, 'powerlevel': powerlevel, 'powers': haspower, 'hp': hp, 'maxhp': hp, 'role': role, 'name': name, 'turn': 0, 'thread': thread});
        });
        // Enemies puttes i et array
        $(xml).find("enemy").each(function () {
            id = parseInt($(this).attr('id'));
            type = parseInt($(this).attr('type'));
            rank = parseInt($(this).attr('rank'));
            powerlevel = parseInt($(this).attr('powerlevel'));
            haspower = [];
            hp = parseInt((type * rank + 1.5) * powerlevel);
            name = $(this).attr('name');
            $(xml).find("enemy[id='" + id + "'] power").each(function () {
                haspower.push(parseInt($(this).attr('id')));
            });
            enemies.push({'id': id, 'actortype': 'e', 'type': type, 'rank': rank, 'powerlevel': powerlevel, 'powers': haspower, 'hp': hp, 'maxhp': hp, 'name': name, 'turn': 2});
        });
        // Powers puttes i et array
        $(xml).find("power").each(function () {
            id = parseInt($(this).attr('id'));
            output = parseInt($(this).attr('output'));
            rounds = parseInt($(this).attr('rounds'));
            cooldown = parseInt($(this).attr('cooldown'));
            target = parseInt($(this).attr('target'));
            cost = parseInt($(this).attr('cost'));
            thread = parseInt($(this).attr('thread'));
            name = $(this).attr('name');
            powerExists = false;
            if ($(this).attr('powerset') === undefined) {
                powerset = 0;
            } else {
                powerset = parseInt($(this).attr('powerset'));
            }
            for (var i = 0; i < powers.length; i++) {
                if (powers[i]['id'] === id) {
                    powerExists = true;
                }
            }
            if (!powerExists) {
                powers.push({'id': id, 'powerset': powerset, 'output': output, 'rounds': rounds, 'cooldown': cooldown, 'target': target, 'cost': cost, 'thread': thread, 'name': name});
            }
        });
        // Actions puttes i et array
        buildActions(xml);
    }

    function buildActions(xml) {
        actions = [];
        $(xml).find("action").each(function () {
            id = parseInt($(this).attr('id'));
            actor = $(this).attr('actor');
            actorTYPE = actor.replace(/\d+/g, '');
            actorID = parseInt(actor.replace(/[^0-9]+/, ''));
            power = parseInt($(this).attr('power'));
            for (var i = 0; i < powers.length; i++) {
                if (powers[i]['id'] === power) {
                    output = parseInt(powers[i]['output']);
                    cost = parseInt(powers[i]['cost']);
                    thread = parseInt(powers[i]['thread']);
                }
            }
            target = $(this).attr('target');
            targetTYPE = target.replace(/\d+/g, '');
            targetID = parseInt(target.replace(/[^0-9]+/, ''));
            movex = parseInt($(this).attr('movex'));
            movey = parseInt($(this).attr('movey'));
            actions.push({'id': id, 'actorTYPE': actorTYPE, 'actorID': actorID, 'power': power, 'output': output, 'targetTYPE': targetTYPE, 'targetID': targetID, 'movex': movex, 'movey': movey, 'cost': cost, 'thread': thread});
        });
    }

    function buildGame(xml) {
        buildArrays(xml);
        for (i = 0; i < characters.length; i++) {
            if (characters[i] !== undefined) {
                id = characters[i]['id'];
                talents = characters[i]['talents'];
                powerlevel = characters[i]['powerlevel'];
                role = characters[i]['role'];
                hp = characters[i]['hp'];
                name = characters[i]['name'];
                $('turns').append("<turn id='" + id + "' actortype='p' position='0'>" + name + "</turn>");
                $("battlegroup").append("<character id='p" + id + "' role='" + role + "' thread='0'><icon>&#10095;<div/></icon>" + name + "<hp value='" + hp + "'><div>" + hp + "(100%)</div></hp><ep value='" + hp + "'><div>" + hp + "(100%)</div></ep></character>");
                $('battle').append("<charactermodel id='p" + id + "' style='top:" + (6.25 * (posP[i][1] - 1) - 1) + "%;left:" + (5 * posP[i][0] + .5) + "%' x='" + posP[i][0] + "' y='" + posP[i][1] + "'></charactermodel>");
            }
        }
        for (i = 0; i < enemies.length; i++) {
            if (enemies[i] !== undefined) {
                id = enemies[i]['id'];
                type = enemies[i]['type'];
                rank = enemies[i]['rank'];
                powerlevel = enemies[i]['powerlevel'];
                hp = enemies[i]['hp'];
                name = enemies[i]['name'];
                $('turns').append("<turn id='" + id + "' actortype='e' position='0'>" + name + "</turn>");
                $("enemygroup").append("<enemy id='e" + id + "'><icon>&#10095;<div/></icon>" + name + "<hp value='" + hp + "'><div>" + hp + "(100%)</div></hp><ep value='" + hp + "'><div>" + hp + "(100%)</div></ep></enemy>");
                $('battle').append("<enemymodel id='e" + id + "' style='top:" + (6.25 * (posE[i][1] - 1) - 1) + "%;left:" + (5 * posE[i][0] + .5) + "%' x='" + posE[i][0] + "' y='" + posE[i][1] + "'></enemymodel>");
            }
        }
        for (i = 0; i < powers.length; i++) {
            if (powers[i] !== undefined) {
                id = powers[i]['id'];
                powerset = powers[i]['powerset'];
                $('powers').append('<power id="' + id + '" powerset=' + powerset + '>' + powers[i]['name'] + '</power>');
            }
        }
        $('power').hide();
    }
    function reloadActions() {
        $.ajax({
            type: "GET",
            url: "/util/battle.php?battle=" + $('battle').attr('id'),
            dataType: "xml",
            success: function (xml) {
                buildActions(xml);
                updateActions();
            }
        });
    }
    function loadActions() {
        // Action før 'pointerActionPos' løbes igennem uden animation eller delay
        for (ci = 0; ci < actions.length && ci < pointerActionPos; ci++) {
            if (actions[ci] !== undefined) {
                atype = actions[ci]['actorTYPE'];
                aid = actions[ci]['actorID'];
                ttype = actions[ci]['targetTYPE'];
                tid = actions[ci]['targetID'];
                output = actions[ci]['output'];
                cost = actions[ci]['cost'];
                thread = actions[ci]['thread'];
                movex = actions[ci]['movex'];
                movey = actions[ci]['movey'];
                setUnitPos(atype, aid, movex, movey);
                if (ttype === "p") {
                    for (var i = 0; i < characters.length; i++) {
                        if (characters[i]['id'] === tid) {
                            calcHP(characters[i], output);
                        }
                    }
                } else {
                    for (var i = 0; i < enemies.length; i++) {
                        if (enemies[i]['id'] === tid) {
                            calcHP(enemies[i], output);
                        }
                    }
                }
                if (atype === "p") {
                    for (var i = 0; i < characters.length; i++) {
                        if (characters[i]['id'] === aid) {
                            calcThread(characters[i], thread);
                            calcCost(characters[i], cost);
                        }
                    }
                } else {
                    for (var i = 0; i < enemies.length; i++) {
                        if (enemies[i]['id'] === aid) {
                            calcCost(enemies[i], cost);
                        }
                    }
                }
            }
        }
        updateGame();
        updateActions();
    }
    function updateActions() {
        // Action efter 'pointerActionPos' løbes igennem med animation og delay
        actionsInterval = setInterval(function () {
            attackspeed = speed;
            if (actions[pointerActionPos] !== undefined && pointerActionPos >= pointerAction) {
                ttype = actions[pointerActionPos]['targetTYPE'];
                tid = actions[pointerActionPos]['targetID'];
                atype = actions[pointerActionPos]['actorTYPE'];
                aid = actions[pointerActionPos]['actorID'];
                output = actions[pointerActionPos]['output'];
                cost = actions[pointerActionPos]['cost'];
                thread = actions[pointerActionPos]['thread'];
                movex = actions[pointerActionPos]['movex'];
                movey = actions[pointerActionPos]['movey'];
                moveUnit(atype + aid, movex, movey);
                if (ttype === "p") {
                    for (var i = 0; i < characters.length; i++) {
                        if (characters[i]['id'] === tid) {
                            calcHP(characters[i], output);
                            hitAnimation(characters[i], ttype, output);
                        }
                    }
                } else {
                    for (var i = 0; i < enemies.length; i++) {
                        if (enemies[i]['id'] === tid) {
                            calcHP(enemies[i], output);
                            hitAnimation(enemies[i], ttype, output);
                        }
                    }
                }
                if (atype === "p") {
                    for (var i = 0; i < characters.length; i++) {
                        if (characters[i]['id'] === aid) {
                            calcThread(characters[i], thread);
                            calcCost(characters[i], cost);
                        }
                    }
                } else {
                    for (var i = 0; i < enemies.length; i++) {
                        if (enemies[i]['id'] === aid) {
                            calcCost(enemies[i], cost);
                        }
                    }
                }
            }
            if (pointerActionPos >= actions.length) {
                clearInterval(actionsInterval);
                readyGame();
            } else {
                pointerActionPos++;
                pointerAction = pointerActionPos;
                updateGame();
            }
            window.history.replaceState("", "REXFUR", "?id=" + $('battle').attr('id') + "&start=" + (pointerAction));
        }, attackSpeed);
    }

    function updateGame() {
        $("pointerAction").html('');
        for (i = 0; i < actions.length; i++) {
            if (actions[i] !== undefined) {
                if (actions[i]['targetTYPE'] === "p") {
                    target = characters;
                    t = "character[id='p";
                } else {
                    target = enemies;
                    t = "enemy[id='e";
                }
                if (actions[i]['actorTYPE'] === "p") {
                    actor = characters;
                    a = "character[id='p";
                } else {
                    actor = enemies;
                    a = "enemy[id='e";
                }
                if (actions[i]['actorTYPE'] === "p") {
                    if (actions[i]['output'] > 0) {
                        color = "448";//p.damage
                    } else if (actions[i]['output'] < 0) {
                        color = "484";//p.heal
                    } else {
                        color = "0cf";//p.utillity
                    }
                } else {
                    if (actions[i]['output'] > 0) {
                        color = "822";//e.damage
                    } else if (actions[i]['output'] < 0) {
                        color = "808";//e.heal
                    } else {
                        color = "fc0";//e.utillity
                    }
                }
                for (var j = 0; j < target.length; j++) {
                    if (target[j]['id'] === actions[i]['targetID']) {
                        hp = target[j]['hp'];
                        maxhp = target[j]['maxhp'];
                        targetname = target[j]['name'];
                    }
                }
                for (var k = 0; k < actor.length; k++) {
                    if (actor[k]['id'] === actions[i]['actorID']) {
                        actorname = actor[k]['name'];
                    }
                }
                for (var l = 0; l < powers.length; l++) {
                    if (powers[l]['id'] === actions[i]['power']) {
                        powername = powers[l]['name'];
                    }
                }
                hpPercent = Math.ceil((hp / maxhp) * 100);
                if (hpPercent < 0) {
                    hpPercent = 0;
                } else if (hpPercent > 100) {
                    hpPercent = 100;
                }
                $(t + actions[i]['targetID'] + "'] hp").attr('value', hp);
                $(t + actions[i]['targetID'] + "'] hp div").css('width', hpPercent + '%').html(hp + '(' + hpPercent + '%)');
                if (i <= pointerActionPos - 1 && i > pointerActionPos - 7) {
                    $("pointerAction").append('<action style="background:#' + color + '" actortype="' + actions[i]['actorTYPE'] + '" id="' + actions[i]['id'] + '">' + powername
                            + '<p>'
                            + actorname + ' > ' + actions[i]['output'] + ' > ' + targetname
                            + '</p><p>'
                            + 'LONG DESCRIPTION OF POWER... Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras maximus, sapien sit amet interdum tempus, augue dolor scelerisque augue, eu egestas orci diam quis tortor. Donec at convallis mauris, ut condimentum lorem. Quisque magna felis, pretium et luctus nec, tempus ac erat. Fusce non faucibus ligula. Cras at nibh risus. Aenean erat nibh, pellentesque vel porta sed, dignissim vitae libero. Donec euismod vulputate purus et suscipit. Aenean vitae lectus non lacus pharetra ultricies. Vivamus tristique finibus ligula a finibus. Duis dignissim sapien enim, et pharetra risus semper eu. Etiam sed tellus nisl. Nullam lobortis eleifend ex quis gravida. Aliquam enim odio, bibendum sed congue nec, consequat et nibh. Praesent pellentesque mauris eu lectus pulvinar interdum. Donec tincidunt dolor vel magna vulputate, sed blandit erat faucibus.'
                            + '</p></action>');
                }
            }
        }
        setThreadPriority();
        actionsFlipped = $("pointerAction").children('action');
        $("pointerAction").append(actionsFlipped.get().reverse());
        if (pointerActionPos <= actions.length) {
            color = $('action:first-of-type').css('background-color');
            $('action:first-of-type').transition({'opacity': 0, 'width': 0}, 0).transition({'opacity': 1, 'width': '40px'}, speed / 2);
            setTimeout(function () {
                $('action:first-of-type').removeAttr('style').css('background-color', color);
            }, speed / 2);
        }
    }
    function updateTurns(list) {
        $('turns').transition({'y': '-100px'}, speed / 4);
        setTimeout(function () {
            $('turns').html('');
            for (var i = 0; i < list.length; i++) {
                id = list[i]['actor']['id'];
                actortype = list[i]['actor']['actortype'];
                turn = list[i]['actor']['turn'];
                name = list[i]['actor']['name'];
                $('turns').append('<turn id="' + id + '" actortype="' + actortype + '" position="' + turn + '">' + name + '</turn>');
            }
            charid = $('turn:first-of-type').attr('actortype') + $('turn:first-of-type').attr('id');
            $('character,enemy').removeAttr('active');
            $('character[id="' + charid + '"],enemy[id="' + charid + '"]').attr('active', '1');
        }, speed / 4);
        $('turns').transition({'y': '0px'}, speed / 4);
    }
    function characterGroupDead() {
        return groupDead(characters);
    }
    function enemyGroupDead() {
        return groupDead(enemies);
    }
    function groupDead(list) {
        var result = true;
        for (i in list) {
            if (list[i]['hp'] > 0) {
                result = false;
            }
        }
        return result;
    }
    function winAnimation() {
        var cturns = actions.length;
        $('battle').append('<end class="win">BATTLE_YOU_WON_IN: ' + cturns + ' BATTLE_TURNS<button>BATTLE_CLAIM_REWARD</button></end>');
        $('end').transition({'opacity': 1}, speed / 2);
    }
    function loseAnimation() {
        var cturns = actions.length;
        $('battle').append('<end class="lose">BATTLE_YOU_LOST_IN: ' + cturns + ' BATTLE_TURNS<button>BATTLE_RETURN_TO_SHIP</button></end>');
        $('end').transition({'opacity': 1}, speed / 2);
    }
    function readyGame() {
        $('#skip').hide();
        if (enemyGroupDead()) {
            winAnimation();
            win = 1;
        } else if (characterGroupDead()) {
            loseAnimation();
            win = 0;
        } else {
            setNextTurn();
            if (currentTurn['type'] === 'p') {
                //Show powerset
                $('power[id="' + currentTurn['id']['powers'][0] + '"],power[id="' + currentTurn['id']['powers'][1] + '"').show();
                showMoveGrid();
            } else {
                $('power').hide();
                enemyTarget = selectTargetCharacter();
                enemyPower = currentTurn['id']['powers'][rand(0, currentTurn['id']['powers'].length - 1)];
                attack(enemyPower, enemyTarget, speed);
            }
        }
    }

    function endGame(hasWon) {
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                window.location.replace('../game');
            }
        };
        xhttp.open('POST', '../util/endgame.php', true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send('status=' + win);
    }
    function selectTargetCharacter() {
        setThreadPriority(charactersC);
        return $('character[thread="0"]').attr('id');
    }
    function setThreadPriority() {
        charactersC = characters.slice();
        charactersC.sort(function (a, b) {
            return b['thread'] - a['thread'];
        });
        $("character thread").removeAttr('highest');
        for (var i = 0; i < charactersC.length; i++) {
            $("character[id='p" + charactersC[i]['id'] + "']").attr('thread', i);
        }
    }
    function showMoveGrid() {
        setTimeout(function () {
            $(this).removeAttr('direction');
            $('position').each(function () {
                id = $('character[active=1]').attr('id');
                x = parseInt($(this).attr('x'));
                y = parseInt($(this).attr('y'));
                ax = parseInt($("charactermodel[id='" + id + "']").attr('x')) - x;
                ay = parseInt($("charactermodel[id='" + id + "']").attr('y')) - y;
                direction = "";
                dirX = "";
                dirY = "";
                spotTaken = $("charactermodel[x='" + x + "'][y='" + y + "'],enemymodel[x='" + x + "'][y='" + y + "']").attr('id');
                if ((ax === -1 || ax === 0 || ax === 1) && (ay === -1 || ay === 0 || ay === 1) && !(ax === 0 && ay === 0) && spotTaken === undefined) {
                    switch (ax) {
                        case 1:
                            dirX = "l";
                            break;
                        case -1:
                            dirX = "r";
                            break;
                    }
                    switch (ay) {
                        case 1:
                            dirY = "t";
                            break;
                        case -1:
                            dirY = "b";
                            break;
                    }
                    direction = dirY + dirX;
                    $(this).css('visibility', 'visible').attr('direction', direction);
                }
            });
        }, speed / 2);
    }
    function attack(power, target, time) {
        attackSpeed = time;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                if (xhttp.responseText == 0) {
                    //SUCCESS
                    reloadActions();
                } else {
                    //FAIL
                    msg(xhttp.responseText);//PHP-ERROR-MSG
                    readyGame();
                }
            }
        };
        textID = currentTurn['type'] + currentTurn['id']['id'];
        x = parseInt($("charactermodel[id='" + textID + "'],enemymodel[id='" + textID + "']").attr('x'));
        y = parseInt($("charactermodel[id='" + textID + "'],enemymodel[id='" + textID + "']").attr('y'));
        url = '../util/action.php?battle=' + $('battle').attr('id') + '&actor=' + textID + '&power=' + power + '&target=' + target + '&movex=' + x + '&movey=' + y;
        xhttp.open('GET', url, true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send();
    }
    function kill(target) {
        target['turn'] = 99999999998;
        $("*[id='" + target['actortype'] + target['id'] + "']").attr('dead', 1);
        msg(target['name'] + "_KILLED");
    }
    function revive(target) {
        target['turn'] = currentTurn['id']['turn'];
        $("*[id='" + target['actortype'] + target['id'] + "']").removeAttr('dead');
        msg(target['name'] + "_LIVES");
    }

    function calcHP(target, output) {
        oldHP = target['hp'];
        target['hp'] = target['hp'] - output;
        if (oldHP === 0 && output < 0) {
            revive(target);
        } else if (target['hp'] <= 0) {
            target['hp'] = 0;
            kill(target);
        } else if (target['hp'] > target['maxhp']) {
            target['hp'] = target['maxhp'];
        }
    }

    function calcCost(actor, cost) {
        actor['turn'] = actor['turn'] + cost;
        $('turn[actortype="' + actor['actortype'] + '"][id="' + actor['id'] + '"]').attr('position', actor['turn']);
    }
    function calcThread(actor, thread) {
        actor['thread'] = actor['thread'] + thread;
    }

    function setNextTurn() {
        $('turns').show();
        nextTurn = [];
        for (var i = 0; i < characters.length; i++) {
            if (characters[i] !== undefined) {
                nextTurn.push({'actor': characters[i]});
            }
        }
        for (var i = 0; i < enemies.length; i++) {
            if (enemies[i] !== undefined) {
                nextTurn.push({'actor': enemies[i]});
            }
        }
        nextTurn.sort(function (a, b) {
            return a['actor']['turn'] - b['actor']['turn'];
        });
        currentTurn['type'] = nextTurn[0]['actor']['actortype'];
        currentTurn['id'] = nextTurn[0]['actor'];
        updateTurns(nextTurn);
    }

    function hitAnimation(target, type, output) {
        effect = {'border': '0.5vw solid #fff', 'line-height': '7.5vw'};
        noeffect = {'border': '.05vw solid #000', 'line-height': '8vw'}
        delaytime = speed * 0.05;
        if (type === "p") {
            tmodel = "charactermodel[id='p";
            t = "character[id='p";
        } else {
            tmodel = "enemymodel[id='e";
            t = "enemy[id='e";
        }
        $(tmodel + target['id'] + "']").html(output).transition(effect, delaytime).transition(noeffect, delaytime).transition(effect, delaytime).transition(noeffect, delaytime);
        hpPercent = Math.ceil((target['hp'] / target['maxhp']) * 100);
        if (hpPercent < 0) {
            hpPercent = 0;
        } else if (hpPercent > 100) {
            hpPercent = 100;
        }
        $(t + target['id'] + "'] hp div").transition({'width': hpPercent + '%'}, speed / 2).html(hpPercent + '%');
        setTimeout(function () {
            $(tmodel + target['id'] + "']").html('');
        }, delaytime * 15);
    }

    function printArray() {
        $('body').html('<pre>' + JSON.stringify(currentTurn) + "\n\n" + JSON.stringify(characters) + "\n\n" + JSON.stringify(enemies) + "\n\n" + JSON.stringify(powers) + "\n\n" + JSON.stringify(actions) + '</pre>');
    }
});