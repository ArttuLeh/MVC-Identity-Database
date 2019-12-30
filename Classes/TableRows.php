<?php
/**
 * Description of TableRows
 *
 * @author Arttu Lehtovaara
 */
class TableRows extends RecursiveIteratorIterator // tulostettavan taulukon muotoilu luokka joka perii valmiin metodin
{ 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width:150px;border:1px solid white;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
}
