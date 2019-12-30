<?php

class MVCIdentityDatabase_Database extends PDO // database luokka perii PDO-rajapinnan
{
    protected $connected; // atribuutti
    public function __construct($user="", $passwd="", $db="") // consructori käyttäjä, salasan, tietokanta- parametreilla
    {
        $this->connected = TRUE; // määritellään yhdistäminen todeksi
        include "Configuration/Mysql.php"; // haetaan kirjautumistiedot
        try // käytetään try-catch silmukkaa yhteyden todentamiseksi
        {
            parent::__construct("mysql:dbname=$db;host=127.0.0.1", $user, $passwd); // uudelleen kirjoitettu constructori
            //tietokanta, localhost, käyttäjä ja salasana parametreilla
            
            // määritetään muuttujaan taulun luominen mikäli taulua ei ole luoto jo
            $create_persons = "create table if not exists serverside19_persons "
                    ."(id char(11) primary key, fname varchar(40) not null, "
                    ."sname varchar(40) not null) "
                    ."default charset=utf8 engine=InnoDB";
            // määritellään toiseen muuttujaan toisen taulun luonti, mikäli ei ole luotu jo
            $create_users = "create table if not exists serverside19_users "
                    ."(user varchar(20) primary key, pwd varchar(40) not null, "
                    ."pri int not null default '0', id char(11) not null, "
                    ."description varchar(80), foreign key (id) references "
                    ."serverside19_persons(id) on delete cascade) "
                    ."default charset=utf8 engine=InnoDB";
            // määritellään lisätyn henkilön poisto muuttujaan
            $delete_persons = "delete from serverside19_persons";
            // määrittellään käyttäjän poisto muuttujaan
            $delete_users = "delete from serverside19_users";
            // määrritellään henkilön lisääminen muuttujaan
            $insert_persons = "insert into serverside19_persons "
                    ."(id, fname, sname) values "
                    ."('12345678901', 'Arttu', 'Lehtovaara')"; // lisätään henkilö tauluun, annetuilla arvoilla
            $insert_users = "insert into serverside19_users " // lisätään käyttäjä tauluun
                    ."(user, pwd, pri, id, description) values "
                    // annteaan käyttäjätunnus, salasana, id ja pääkäyttäjä arvo
                    ."('spede', md5('keijo'), '0', '12345678901', 'Pääkäyttäjä')";
            $show_tables = "show tables like 'serverside19_%s%s'"; // taulun tulostaminen määritellään muuttujaan
            
            $stm = $this->prepare($show_tables); // kutsutaan show_tables muuttujaa PDO rajapinnan valmiilla metodilla
            $stm->execute();
            if ($stm->rowCount() != 2)
            {   // luodaan taulut tietokantaan PDO- rajapinnan metodeilla
                $this->prepare($create_persons)->execute(); // 
                $this->prepare($create_users)->execute();
                $this->prepare($delete_users)->execute();
                $this->prepare($delete_persons)->execute();
                $this->prepare($insert_persons)->execute();
                $this->prepare($insert_users)->execute();
            }

        }
        catch (Exception $ex)
        {
            $this->connected = FALSE; // mikäli yhteys ei onnistunut                    
        }
    }


}
