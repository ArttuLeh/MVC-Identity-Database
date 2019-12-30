<?php
/**
 * Description of MVCIdentityDatabaseController
 *
 * @author Arttu Lehtovaara
 */
class MVCIdentityDatabaseController 
{

    
    public function __construct() 
    {

        $db = new MVCIdentityDatabase_Database(); // määritetään tietokannan yhdistys luokka muuttujaan
        $id = "";
        $fname = "";
        $sname = "";
        session_start();
        function getPosts() // tekstikenttien tietojen vastaanottaja funktio
        {
            $posts = array();
            $posts[0] = $_POST['id'];
            $posts[1] = $_POST['fname'];
            $posts[2] = $_POST['sname'];
            return $posts;
        }
        
        function alert($msg) // alert box funktio
        {
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }

        if (isset($_POST['kirjaudu'])) //sisäänkirjautuminen
        {
            $user = $_POST['käyttäjä'];

            if (empty($_POST['käyttäjä']) || empty($_POST['salasana'])) // Testataan onko tiedot laitettu tekstikenttiin
            {
                echo "Täytä kentät!"; 
            }
            else
            {
                // tarkastetaan täsmäävätkö tiedot tietokannan käyttäjän tietoihin
                $login = $db->prepare("select user, pwd from serverside19_users where user ='".$_POST["käyttäjä"]."' and pwd = '".md5($_POST['salasana'])."'");
                $login->execute();
                $row = $login->fetchALL(PDO::FETCH_CLASS);
                if (count($row) > 0) // testataan onko tietokannassa käyttäjän tiedot
                {
                    $_SESSION['käyttäjä'] = $user; // mikäli löytyy, käyttäjä on kirjautunut sisään sessioon 
                    echo "Kirjauduttu sisään käyttäjällä: $user";
                }
                else
                {
                    echo "Kirjautuminen ei onnistunut";
                }
            }
        }
        
        if (isset($_SESSION['käyttäjä'])) // testataan onko käyttäjä kirjautunut
        {
            $user = $_SESSION['käyttäjä'];
    
            if(isset($_POST['lisää'])) // mikäli käyttäjä on kirjautunut voi hän lisätä tietoja tietokantaan
            {
                $data = getPosts(); // getPost() funktio palauttaa tekstikentän tiedot
                if(empty($data[0]) || empty($data[1]) || empty($data[2])) // testataan onko kentät täyttetty
                {
                    echo "Lisää tiedot tekstikenttiin!";
                }
                else 
                {
                    // lisätään henkilö tietokantaan
                    $insertStmt = $db->prepare("insert into serverside19_persons values(:id,:fname,:sname)");
                    $insertStmt->execute(array(
                                ":id"=> $data[0],
                                ":fname"=> $data[1],
                                ":sname"=> $data[2],
                    ));

                    if($insertStmt)
                    {
                            echo "Henkilö lisätty!";
                    }

                }
            }
            if (isset($_POST['päivitä'])) // mikäli käyttäjä kirjautunut voi hän päivittää tietoja
            {
                $data = getPosts();
                if (empty($data[0]) || empty($data[1]) || empty($data[2]))
                {
                    echo "Täytä tekstikentät!";
                }
                else
                {   // päivitetään tiedot tietokantaan
                    $updateStmt = $db->prepare("update serverside19_persons set fname = :fname, sname = :sname where id = :id");
                    $updateStmt->execute(array(
                       ":id"=>$data[0],
                        ":fname"=>$data[1],
                        ":sname"=>$data[2]
                    ));
                    if ($updateStmt)
                    {
                        echo "Henkilö päivitetty!";
                    }
                }
            }
            if(isset($_POST['poista'])) // mikäli käyttäjä on kirjautunut voi hän poistaa tietoja tietokannasta
            {
                $data = getPosts();
                if(empty($data[0]))
                {
                    echo "Täytä ID tekstikenttä!";
                }
                else 
                {
                    // poistetaan tiedot tietokannasta
                    $deleteStmt = $db->prepare("delete from serverside19_persons where id = :id");
                    $deleteStmt->execute(array(
                                ":id"=> $data[0]
                    ));

                    if($deleteStmt)
                    {
                            echo "Henkilö poistettu!";
                    }

                }
            }
        }
        if (!isset ($_SESSION['käyttäjä']))
        {
            if (isset($_POST['lisää'])) // mikäli käyttäjä painaa "lisää" -painikettä, alert box ilmoittaa mitä tehdä
            {
                alert("Kirjaudu sisään lisätäksesi henkilön tietokantaan!");
                //echo "Kirjaudu sisään lisätäksesi henkilön tietokantaan!";
            }
        }
        if (!isset ($_SESSION['käyttäjä']))
        {
            if (isset($_POST['päivitä'])) // mikäli käyttäjä painaa "päivitä" -painikettä, alert box ilmoittaa mitä tehdä
            {
                alert("Kirjaudu sisään päivittääksesi tietokantaa!");
                //echo "Kirjaudu sisään päivittääksesi tietokantaa";
            }
        }
        if (!isset ($_SESSION['käyttäjä']))
        {    
            if (isset($_POST['poista'])) // mikäli käyttäjä painaa "poista" -painikettä, alert box ilmoittaa mitä tehdä
            {
                alert("Kirjaudu sisään poistaaksesi henkilön tietokannasta!");
                //echo "Kirjaudu sisään poistaaksesi henkilön tietokannasta";
            }
        }
        
        if (isset($_POST['ulos'])) // kirjaudutaan ulos kun käyttäjä painaa "kirjaudu ulos"- painiketta
        {
            //session_start();
            unset($_SESSION['käyttäjä']);
            unset($_SESSION['salasana']);
            echo "Kirjauduttu ulos!";
        }

        if (isset($_POST['etsi'])) // ilman kirjautumista voi etsiä henkilöitä tietokannasta
        {
            $data = getPosts();
            if (empty($data[1]) || empty($data[2]))
            {
                echo "Täyty etu- ja sukunimi tekstikenttä!";
            }
            else
            {   // valitaan tietokannasta annetuilla tiedoilla etsitty henkilö
                $searchStmt = $db->prepare("select * from serverside19_persons where fname = :fname and sname = :sname");
                $searchStmt->execute(array(
                    ":fname"=>$data[1],
                    ":sname"=>$data[2]));
                $res = $searchStmt->setFetchMode(PDO::FETCH_ASSOC);
                // tulostettavan taulukon muotoilua
                echo "<table style='margin-top:10px;margin-left:100px;border: solid 1px white;'>";
                echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";
                // tulostettavan taulukon muotoilua ja tulostus
                foreach (new TableRows(new RecursiveArrayIterator($searchStmt->fetchAll())) as $k=>$v)
                {
                    echo $v;
                }
            }
        }
        if (isset($_POST['kaikki'])) // käyttäjä voi ilman sisäänkirjautumista hakea kaikkia tietoja tietokannasta
        {
            $showAll = $db->prepare("select id, fname, sname from serverside19_persons");
            $showAll->execute();
            $res = $showAll->setFetchMode(PDO::FETCH_ASSOC);
            // tulostettavan taulukon muotoilua
            echo "<table style='margin-top:10px;margin-left:100px;border: solid 1px white;'>";
            echo "<tr><th>Id</th><th>Firstname</th><th>Lastname</th></tr>";
            // tulostettavan taulukon muotoilua ja tulostu
            foreach (new TableRows(new RecursiveArrayIterator($showAll->fetchAll())) as $k=>$v)
            {
                echo $v;
            }
        }

    }
}