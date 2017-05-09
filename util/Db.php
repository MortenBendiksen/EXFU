<?php

$path = $_SERVER['DOCUMENT_ROOT'];
include_once "$path/model/Player.php";
include_once "$path/model/Battlegroup.php";
include_once "$path/model/BattleCharacter.php";
include_once "$path/model/Powerset.php";
include_once "$path/model/Power.php";

class DB {

    private $strsqlword, $strsqlrepalce, $SQL, $intinsertID;

    function __construct() {
        $this->strsqlword = array('<', '>', '*', 'SELECT ', 'UPDATE ', 'DELETE ', 'INSERT ', 'INTO', 'VALUES', 'FROM', 'DISTINCT', 'LEFT', 'RIGHT', 'JOIN', 'WHERE', 'LIKE', 'LIMIT', 'ORDER BY', 'GROUP BY', 'AND', 'OR ', 'DESC', 'ASC', 'ON ', 'INNER', 'OUTER', 'SHOW FIELDS', ',', '\'', '%', '_');
        $this->strsqlreplace = array('&lt;', '&gt;', '<span style="color:#f80;">*</span>', '<span style="color:#f80;">SELECT </span>', '<span style="color:#f80;">UPDATE </span>', '<span style="color:#f80;">DELETE </span>', '<span style="color:#f80;">INSERT </span>', '<span style="color:#f80;">INTO</span>', '<span style="color:#f80;">VALUES</span>', '<span style="color:#f80;">FROM</span>', '<span style="color:#f80;">DISTINCT</span>', '<span style="color:#f80;">LEFT</span>', '<span style="color:#f80;">RIGHT</span>', '<span style="color:#f80;">JOIN</span>', '<span style="color:#f80;">WHERE</span>', '<span style="color:#f80;">LIKE</span>', '<span style="color:#f80;">LIMIT</span>', '<span style="color:#f80;">ORDER BY</span>', '<span style="color:#f80;">GROUP BY</span>', '<span style="color:#f80;">AND</span>', '<span style="color:#f80;">OR </span>', '<span style="color:#f80;">DESC</span>', '<span style="color:#f80;">ASC</span>', '<span style="color:#f80;">ON </span>', '<span style="color:#f80;">INNER</span>', '<span style="color:#f80;">OUTER</span>', '<span style="color:#f80;">SHOW FIELDS</span>', '<span style="color:#f80;">,</span>', '<span style="color:#f80;">\'</span>', '<span style="color:#80f;">%</span>', '<span style="color:#80f;">_</span>');
        $this->intinsertID = 0;
    }

    private function connect() {
        try {
            $this->SQL = new PDO("mysql:host=localhost;dbname=rexfur", "root", "");
            $this->SQL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    private function disconnect() {
        $this->SQL = null;
    }

    public function select($newSQL, $echo = false) {
        $this->connect();
        $query = $this->SQL->prepare($newSQL);
        $query->execute();
        $return = $query;
        $this->disconnect();
        if ($echo) {
            $newSQL = str_ireplace($this->strsqlword, $this->strsqlreplace, $newSQL);
            echo "<span style='display:block;color:#0f0;font-weight:bold;'>$newSQL</span>";
        }
        return $return;
    }

    public function update($tabel, $array_fields, $array_values, $where, $echo = false) {
        $sql = "";
        if (count($array_fields) == count($array_values)) {
            $update = [];
            for($i=0;$i<count($array_fields);$i++){
                $update[] = "$array_fields[$i] = '$array_values[$i]'";
            }
            $update = implode(', ', $update);
            //   UPDATE `battlegroup` SET `intincombat` = '70' WHERE `battlegroup`.`id` = 6;
            $sql = 'UPDATE ' . $tabel . ' SET ' . $update . ' WHERE ' . $where;
            if ($echo) {
                //$newSQL = str_ireplace($this->strsqlword, $this->strsqlreplace, $sql);
                $newSQL = $sql;
                echo "<span style='display:block;color:#0f0;font-weight:bold;'>$newSQL</span>";
            }
            $this->connect();
            $query = $this->SQL->prepare($sql);
            $query->execute();
            $this->disconnect();
        } else {
            $err = debug_backtrace();
            $file = explode('public_html', $err [0] ['file']);
            echo "<span style='color:red;'>Misforhold i antallet af <strong>felter</strong> og <strong>værdier</strong> i <strong>Objekt-metoden insertAny()</strong>, dette skyldes at \$fields har <strong>" . count($array_fields) . "</strong> felt(er) og \$values har <strong>" . count($array_values) . "</strong> felt(er) i array'et.<br />
				Denne fejl blev fundet her: <strong>" . $file [1] . "</strong> på linie <strong>" . $err [0] ['line'] . "</strong></span>";
        }
    }

    public function insert($tabel, $array_fields, $array_values, $echo = false) {
        $sql = "";
        if (count($array_fields) == count($array_values)) {
            $fields = implode(',', $array_fields);
            $values = implode('","', $array_values);
            $sql = 'INSERT INTO ' . $tabel . ' (' . $fields . ') VALUES ("' . $values . '")';
            if ($echo) {
                //$newSQL = str_ireplace($this->strsqlword, $this->strsqlreplace, $sql);
                $newSQL = $sql;
                echo "<span style='display:block;color:#0f0;font-weight:bold;'>$newSQL</span>";
            }
            $this->connect();
            $query = $this->SQL->prepare($sql);
            $query->execute();
            $this->setIntinsertID($this->SQL->lastInsertId());
            $this->disconnect();
        } else {
            $err = debug_backtrace();
            $file = explode('public_html', $err [0] ['file']);
            echo "<span style='color:red;'>Misforhold i antallet af <strong>felter</strong> og <strong>værdier</strong> i <strong>Objekt-metoden insertAny()</strong>, dette skyldes at \$fields har <strong>" . count($array_fields) . "</strong> felt(er) og \$values har <strong>" . count($array_values) . "</strong> felt(er) i array'et.<br />
				Denne fejl blev fundet her: <strong>" . $file [1] . "</strong> på linie <strong>" . $err [0] ['line'] . "</strong></span>";
        }
    }

    public function verify($user, $password, $antikeylog) {
        $passHash = "";
        $antiHash = "";
        $id = "";
        $this->connect();
        $userDB = $this->select("select id,intsecuritylevel,strpassword,intantikeylog from player where stremail='$user'");
        while ($row = $userDB->fetch()) {
            $passHash = $row['strpassword'];
            $antiHash = $row['intantikeylog'];
            $id = $row['id'];
            $securitylevel = $row['intsecuritylevel'];
        }
        $this->disconnect();
        if (password_verify($password, $passHash) && ($securitylevel == 0 || password_verify($antikeylog, $antiHash))) {
            $userDB = $this->select("select id,strpassword,intantikeylog from player where stremail='$user'");
            while ($row = $userDB->fetch()) {
                $passHash = $row['strpassword'];
                $antiHash = $row['intantikeylog'];
                $id = $row['id'];
            }
            $result = $id;
        } else {
            $result = 0;
        }
        return $result;
    }

    public function logout($player) {
        $this->update('player', ['intlogout'], [time()], "stremail='{$player->getStrEmail()}'");
    }

    public function getIntinsertID() {
        return $this->intinsertID;
    }

    private function setIntinsertID($intinsertID) {
        $this->intinsertID = $intinsertID;
    }

    public function startBattle($fight, $battlegroup) {
        $this->insert('battle', ['fk_battlegroup','fk_fight'], [$battlegroup, $fight]);
        $battleID = $this->getIntinsertID();
        $battlegroup = unserialize($_SESSION['battlegroup'])[$_SESSION['selectedbattlegroup']];
        foreach ($battlegroup->getArrMembers() as $char) {
            $this->insert('battlestatsnapshot', ['fk_battle', 'fk_battlecharacter', 'intpowerlevel', 'inttalents'], [$battleID, $char->getIntID(), $char->getIntPowerlevel(), 0], true);
        }
        $this->update('battlegroup', ['intincombat'], [$battleID], "id = {$battlegroup->getIntID()}", true);
    }

    public function login($userID) {
        $userDB = $this->select("select * from player where id='$userID'");
        while ($row = $userDB->fetch()) {
            $strDisplayName = $row['strdisplayname'];
            $strlanguage = $row['strlanguage'];
            $intSecurityLevel = $row['intsecuritylevel'];
            $strEmail = $row['stremail'];
            $strPassword = $row['strpassword'];
            $intAntiKeylog = $row['intantikeylog'];
            $intPlayerLevel = $row['intplayerlevel'];
            $intPlayerXP = $row['intplayerxp'];
            $player = new Player($userID,$strDisplayName, $strlanguage, $intSecurityLevel, $strEmail, $strPassword, $intAntiKeylog, $intPlayerLevel, $intPlayerXP);
        }
        $userDB = $this->select("select battlegroup.id,battlegroup.strname,battlegroup.intincombat from player join battlegroup on battlegroup.fk_player = player.id where player.id='$userID'");
        while ($row = $userDB->fetch()) {
            $groupID = $row['id'];
            $strName = $row['strname'];
            $intInCombat = $row['intincombat'];
            $bg = new Battlegroup($groupID, $strName, $intInCombat, 'strShipName', 'colShipColor', 'intShipInternet', 'intShipCPU');
            $groupDB = $this->select("SELECT battlecharacter.id,battlecharacter.strname,battlecharacter.intpowerlevel,battlecharacter.intstrength,battlecharacter.fk_powerset as powerset,battlecharacter.fk_secondarypowerset as secondarypowerset,battlecharacter.fk_battlegroup as 'group', role.strname as 'role' FROM player join battlegroup on battlegroup.fk_player = player.id join battlecharacter on battlecharacter.fk_battlegroup = battlegroup.id join role on battlecharacter.fk_role = role.id WHERE player.id='$userID'");
            while ($char = $groupDB->fetch()) {
                if ($groupID == $char['group']) {
                    $charID = $char['id'];
                    $chstrName = $char['strname'];
                    $chstrRole = $char['role'];
                    $chintPowerlevel = $char['intpowerlevel'];
                    $chintStrength = $char['intstrength'];
                    $powersetDB = $this->select("select * from powerset");
                    while ($powerset = $powersetDB->fetch()) {
                        if ($char['powerset'] == $powerset['id']) {
                            $psetName = $powerset['strname'];
                            $psetType = $powerset['inttype'];
                            $powersetObj = new Powerset($psetName, $psetType, '$psetImagePath', '$psetAudioPath');
                            $powerDB = $this->select("select id,strname,inttotaloutput,introunds,intcooldown,inttarget from powers where fk_powerset = '{$powerset['id']}'");
                            while ($power = $powerDB->fetch()) {
                                $strName = $power['strname'];
                                $intTotalOutput = $power['inttotaloutput'];
                                $intRounds = $power['introunds'];
                                $intCooldown = $power['intcooldown'];
                                $intTarget = $power['inttarget'];
                                $powerObj = new Power($strName, $intTotalOutput, $intRounds, $intCooldown, $intTarget);
                                $powersetObj->addPower($powerObj);
                            }
                        }
                        if ($char['secondarypowerset'] == $powerset['id']) {
                            $spsetName = $powerset['strname'];
                            $spsetType = $powerset['inttype'];
                            $secPowerset = new Powerset($spsetName, $spsetType, '$psetImagePath', '$psetAudioPath');
                            $spowerDB = $this->select("select id,strname,inttotaloutput,introunds,intcooldown,inttarget from powers where fk_powerset = '{$powerset['id']}'");
                            while ($power = $spowerDB->fetch()) {
                                $strName = $power['strname'];
                                $intTotalOutput = $power['inttotaloutput'];
                                $intRounds = $power['introunds'];
                                $intCooldown = $power['intcooldown'];
                                $intTarget = $power['inttarget'];
                                $powerObj = new Power($strName, $intTotalOutput, $intRounds, $intCooldown, $intTarget);
                                $secPowerset->addPower($powerObj);
                            }
                        }
                    }
                    $member = new BattleCharacter($charID, $chstrName, $chstrRole, $chintPowerlevel, $chintStrength, $powersetObj, $secPowerset);
                    $bg->addMember($member);
                }
            }
            $battlegroup[] = $bg;
        }

        $_SESSION['player'] = serialize($player);
        $_SESSION['battlegroup'] = serialize($battlegroup);
    }

    public function refresh($userID) {
        $this->login($userID);
    }

}
