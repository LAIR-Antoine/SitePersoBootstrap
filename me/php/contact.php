

<?php

  $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "",
   "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => "false",);

  $emailTo = "lairantoine@orange.fr";

  if ($_SERVER["REQUEST_METHOD"] == "POST") # affiché les valeurs déjà saisies par l'utilisateur
  {
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";

    if(empty($array["firstname"]))
    {
      $array["firstnameError"] = "Je veux connaître ton prénom !";
      $array["isSuccess"] = false;
    }
    else {
      $emailText .= "FirstName: {$array["firstname"]}\n";
    }

    if(empty($array["name"]))
    {
      $array["nameError"] = "Si j'ai pas ton nom, comment puis-je te répondre ?";
      $array["isSuccess"] = false;
    }
    else {
      $emailText .= "Name: {$array["name"]}\n";
    }

    if(!isEmail($array["email"]))
    {
      $array["emailError"] = "Malheuresement, cet email n'est pas valide !";
      $array["isSuccess"] = false;
    }
    else {
      $emailText .= "Email: {$array["email"]}\n";
    }

    if(!isPhone($array["phone"]))
    {
      $array["phoneError"] = "Que des chiffres et des espaces svp...";
      $array["isSuccess"] = false;
    }
    else {
      $emailText .= "Téléphone: {$array["phone"]}\n";
    }

    if(empty($array["message"]))
    {
      $array["messageError"] = "Qu'est-ce que tu veux me dire ?";
      $array["isSuccess"] = false;
    }
    else {
      $emailText .= "Message: {$array["message"]}\n";
    }

    if($array["isSuccess"])
    {
      $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\nReply-To: {$array["email"]}";
      mail($emailTo, "Un message de votre site", $emailText, $headers); # mail(Destinataire, Objet, Contenu, En-tête);
    }

    echo json_encode($array);

  }

  function isEmail($var)
  {
    return filter_var($var, FILTER_VALIDATE_EMAIL);
  }

  function isPhone($var)
  {
    return preg_match("/^[0-9 ]*$/", $var); # énormement de vérifications possibles avec preg_match
  }


  function verifyInput($var) # pour la sécurité
  {
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);

    return $var;
  }

?>
