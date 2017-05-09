<?php

class Formular {

    private $page;

    function __construct() {
        
    }

    public function text($id, $name, $startText = "", $label = "", $autofill = "") {
        $res = "";
        if ($label != "") {
            $res .= "<label for='$id'>$label</label>\n";
        }
        if ($autofill != "") {
            $autofill .= " autocomplete='off' ";
        }
        $res .= "<input type='text' id='$id' name='$name' placeholder='$startText'$autofill/>\n";
        return $res;
    }

    public function password($id, $name, $startText = "", $label = "", $autofill = "") {
        $res = "";
        if ($label != "") {
            $res .= "<label for='$id'>$label</label>\n";
        }
        if ($autofill != "") {
            $autofill .= " autocomplete='off' ";
        }
        $res .= "<input type='password' id='$id' name='$name' placeholder='$startText'$autofill/>\n";
        return $res;
    }

    public function select($id, $items, $items_text, $label = "", $selected_item="") {
        $res = "";
        if ($label != "") {
            $res .= "<label>$label</label>\n";
        }
        $res.="<select id='$id'>";
        for ($i = 0; $i < count($items); $i++) {
            if ($items[$i]==$selected_item) {
                $selected = " selected";
            }else{
                $selected = "";
            }
            $res.="<option value='$items[$i]'$selected>$items_text[$i]</option>";
        }
        $res.="</select>";
        return $res;
    }

    public function button($id, $name) {
        $res = "<button type='button' id='$id'>$name</button>";
        return $res;
    }

}
