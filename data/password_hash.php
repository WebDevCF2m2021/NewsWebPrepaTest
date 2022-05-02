<?php
// exemple de base
$mdp = "CouCou56AVous77Zp5";
$mdp_ph = password_hash($mdp,PASSWORD_DEFAULT );

if(isset($_POST['mdp'])){
    if(password_verify($_POST['mdp'],$mdp_ph)){
        $mes1 = "Mot de passe correcte";
    }else{
        $mes1 = "Mot de passe incorrecte";
    }
}
if(isset($_POST['mypwd'])){
    $mes2 = $_POST['mypwd']."<br>";
    $mes2 .= password_hash($_POST['mypwd'],PASSWORD_DEFAULT );
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>password_hash</title>
</head>
<body>

<pre>
$mdp = "CouCou56AVous77Zp5";
$mdp_ph = password_hash($mdp, PASSWORD_DEFAULT );
</pre>
<p>donnera une clef changeante</p>
<p><?=$mdp?><br>
<?=$mdp_ph?></p>
<form action="" method="post" name="transform">
    <input type="text" name="mdp" value="<?=$mdp?>"><br>
    <input type="submit" value="Vérifier">
</form>
<?php if(isset($mes1)) echo "<h3>$mes1</h3>"?>
<hr>
    <form action="" method="post" name="test">
        <input type="text" name="mypwd"><br>
        <input type="submit" value="Générer">
    </form>
<?php if(isset($mes2)) echo "<p>$mes2</p>"?>
<h3>Et un id unique</h3>
<p><?=uniqid(more_entropy: true)?></p>
</body>
</html>
