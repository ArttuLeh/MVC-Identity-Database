<!DOCTYPE html>
<style>
<?php include "style.css";?>
</style>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MVCIdentity database</title>
    </head>
    <body>
        <div id="eka">
            <h1>Tervetuloa</h1>
        </div>
        <div id="toka">
            <p>Tämä on tietokannan hallintajärjestelmä. Kirjaudu sisään hallitaksesi tietokantaa (henkilön lisäys, päivitys ja poisto). 
            Jos sinulla ei ole tunnusta voit hakea henkilöitä tietokannasta etu- ja sukunimen perusteella.</p>
        <?=
            "<br>";
            $form = new Form([
                (new Element("span","","", [
                    "Käyttäjänimi: ", (new Text("käyttäjä"))
                    ->addStyle("margin-bottom", "5px"),
                    "Salasana: ", new Password("salasana"),
                    (new Submit("kirjaudu", "Kirjaudu sisään"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white")
                    ->addStyle("margin-top", "5px"),
                    (new Submit("ulos", "Kirjaudu ulos"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white"),
                ]))
            ]);
            echo $form;
        ?>
        </div>
        
        <div id="kolmas">
        <?=
            "<br>";
            $form = new Form([
                (new Element("span","","", [
                    "Henkilön ID: ", (new Text("id"))
                    ->addStyle("margin-bottom", "5px"),
                    "Etunimi: ", (new Text("fname"))
                    ->addStyle("margin-bottom", "5px"),
                    "Sukunimi: ", new Text("sname"), "<br>",
                    (new Submit("etsi", "Etsi"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white")
                    ->addStyle("margin-top", "5px"),
                    (new Submit("lisää", "Lisää"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white"),
                    (new Submit("kaikki", "Kaikki"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white"),
                    (new Submit("päivitä", "Päivitä"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white"),
                    (new Submit("poista", "Poista"))
                    ->addStyle("border-radius", "12px")
                    ->addStyle("background-color", "green")
                    ->addStyle("color", "white"),
                    
                ]))
            ]);
            echo $form;
        ?>
        </div>
    </body>
</html>
