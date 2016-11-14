<?php
    
    /*looks for professor IDs through main faculty page. *WORKS OFFLINE ONLY*
    $mainPage = fopen("https://cs.txstate.edu/accounts/faculty/") or die("https://cs.txstate.edu/accounts/faculty/"); //online version
    $mainPage = fopen("faculty.htm", "r") or die("Unable to open faculty.htm!"); //opens main department page //offline version
    $curRead = fread($mainPage,filesize("faculty.htm"))or die("Unable to read faculty.htm!"); //stores main page text into $curRead
    $extractIDMain = '/<h3 class="title"><a href="\/accounts\/profiles\/([a-z0-9_]+)/'; //regEx for finding faculty IDs
    if (preg_match_all($extractIDMain, $curRead, $facultyIDs)) {
        echo 'found ids<br>';
    }
    fclose($mainPage); //closes main department page
    */
    
    $facultyIDs = array("hs15", "jg66", "ma04", "mb92"); //ids to use for offline & non-main faculty page extraction 

    //Regular Expressions:
    $extractName = '/"current">\\n +\\n +([ a-zA-Z.()]+)\\n +\\n +\\n +([ a-zA-Z.\(\)\-]+)/'; //regEx for finding Name
    $extractEducation = '/Education<\/h3>\\n +<\/div>\\n +<div class="panel-body"><p>([ _.\&;,a-zA-z0-9]+)/'; //regEx for finding Education
    $extractInterests = '/Research Interests<\/h3>\\n +<\/div>\\n +<div class="panel-body"><p>([-a-zA-z,;\&()\/\\ ]+)/'; //regEx for finding interests
    $extractEmail ='/\/cms\/email_image\/\?user=([-a-z.A-z_0-9]+)/'; //regEx for finding email
    
    //foreach($facultyIDs[1] as $id) {   //for use with mainpage extraction method only. *FAILS ON FIRST WEBPAGE WITHOUT ACCESS*
        //$curPage = fopen('https://cs.txstate.edu/accounts/profiles/'.$id, "r") die("Unable to read ".$id.".htm from web"); //online version of profile page extraction
    foreach($facultyIDs as $id) { //offline verison loop of through ids
        $curPage = fopen($id.".htm", "r") or die("Unable to open ".$id.".htm!");
        $curRead = fread($curPage,filesize($id.".htm"))or die("Unable to read file");
        if (!preg_match_all($extractName, $curRead, $Name)) {
            echo 'Name not found!<br>';
        }
        if (!preg_match_all($extractEducation, $curRead, $Education)) {
            echo 'Education not found!<br>';
        }
        if (!preg_match_all($extractInterests, $curRead, $interests)) {
            echo 'Interests not found!<br>';
        }
        if (!preg_match_all($extractEmail, $curRead, $email)) {
            echo 'email not found!<br>';
        }

        fclose($curPage); //closes the current page

        //Writes the information for user down in txt file
        $curOuput = fopen($id.".txt", "w");
        $txt = 
"Name: ".$Name[1][0]." ".$Name[2][0]."
Education: ".(str_replace("&amp;", "&", $Education[1][0]))."
Research interests: ".$interests[1][0]."
Email: ".$email[1][0]."@txstate.edu
Webpage: http://cs.txstate.edu/~".$id;
        fwrite($curOuput, $txt);
        fclose($curOuput);
        $numFiles++;
    }
    echo $numFiles." files output.";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>

