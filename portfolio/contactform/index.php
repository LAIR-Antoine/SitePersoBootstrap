<?php
  $firstname = $name = $email = $phone = $message = "";
  $firstnameError = $nameError = $emailError = $phoneError = $messageError = "";
  $isSuccess = false;
  $emailTo = "lairantoine@orange.fr";

  if ($_SERVER["REQUEST_METHOD"] == "POST") # affiché les valeurs déjà saisies par l'utilisateur
  {
    $firstname = verifyInput($_POST["firstname"]);
    $name = verifyInput($_POST["name"]);
    $email = verifyInput($_POST["email"]);
    $phone = verifyInput($_POST["phone"]);
    $message = verifyInput($_POST["message"]);
    $isSuccess = true;
    $emailText = "";

    if(empty($firstname))
    {
      $firstnameError = "Je veux connaître ton prénom !";
      $isSuccess = false;
    }
    else {
      $emailText .= "FirstName: $firstname\n";
    }

    if(empty($name))
    {
      $nameError = "Et oui je veux tout savoir, même ton nom !";
      $isSuccess = false;
    }
    else {
      $emailText .= "Name: $name\n";
    }

    if(!isEmail($email))
    {
      $emailError = "Je sais que ce n'est pas ton email !";
      $isSuccess = false;
    }
    else {
      $emailText .= "Email: $email\n";
    }

    if(!isPhone($phone))
    {
      $phoneError = "Que des chiffres et des espaces svp...";
      $isSuccess = false;
    }
    else {
      $emailText .= "Téléphone: $phone\n";
    }

    if(empty($message))
    {
      $messageError = "Qu'est-ce que tu veux me dire ?";
      $isSuccess = false;
    }
    else {
      $emailText .= "Message: $message\n";
    }

    if($isSuccess)
    {
      $headers = "From: $firstname $name <$email>\r\nReply-To: $email";
      mail($emailTo, "Un message de votre site", $emailText, $headers); # mail(Destinataire, Objet, Contenu, En-tête);
      $firstname = $name = $email = $phone = $message = "";
    }

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

<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <title>Contactez-Moi !</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>

  <body>

     <div class="container">
          <div class="divider"></div>
          <div class="heading">
              <h2>Contactez-moi</h2>
          </div>

         <div class="row">
             <div class="col-lg-10 col-lg-offset-1">
                  <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                      <div class="row">
                          <div class="col-md-6">
                              <label for="firstname">Prénom <span class="blue">*</span></label>
                              <input id="firstname" type="text" name="firstname" class="form-control" placeholder="Votre prénom" value="<?php echo $firstname; ?>">
                              <p class="comments"><?php echo $firstnameError; ?></p>
                          </div>
                          <div class="col-md-6">
                              <label for="name">Nom <span class="blue">*</span></label>
                              <input id="name" type="text" name="name" class="form-control" placeholder="Votre Nom" value="<?php echo $name; ?>">
                              <p class="comments"><?php echo $nameError; ?></p>
                          </div>
                          <div class="col-md-6">
                              <label for="email">Email <span class="blue">*</span></label>
                              <input id="email" type="email" name="email" class="form-control" placeholder="Votre Email" value="<?php echo $email; ?>">
                              <p class="comments"><?php echo $emailError; ?></p>
                          </div>
                          <div class="col-md-6">
                              <label for="phone">Téléphone</label>
                              <input id="phone" type="tel" name="phone" class="form-control" placeholder="Votre Téléphone" value="<?php echo $phone; ?>">
                              <p class="comments"><?php echo $phoneError; ?></p>
                          </div>
                          <div class="col-md-12">
                              <label for="message">Message <span class="blue">*</span></label>
                              <textarea id="message" name="message" class="form-control" placeholder="Votre Message" rows="4"><?php echo $message; ?></textarea>
                              <p class="comments"><?php echo $messageError; ?></p>
                          </div>
                          <div class="col-md-12">
                              <p class="blue"><strong>* Ces informations sont requises.</strong></p>
                          </div>
                          <div class="col-md-12">
                              <input type="submit" class="button1" value="Envoyer">
                          </div>
                      </div>

                      <p class="thank-you" style="display:<?php if($isSuccess) echo 'block'; else echo 'none'; ?>">Votre message a bien été envoyé. Merci de m'avoir contacté :)</p>

                  </form>
              </div>
         </div>
      </div>

  </body>
</html>
