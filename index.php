<!doctype html>

<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="stylesheet" media="screen" href="ui/global.css" />

<title>DWaM - Domain Whack-a-Mole</title>
</head>

<body>
<h1><a href="<?= str_replace('index.php', '', $_SERVER['PHP_SELF']); ?>" tabindex="1">DWaM <span>Domain Whack-a-Mole</span></a></h1>
<?php

require_once 'vendor/autoload.php';

$form = "\n" .
'<form method="post">
  <p><label for="domain" class="hidden">Domain name</label> <input type="text" name="dwam-domain" id="domain" placeholder="example.com" tabindex="2" /></p>
  <p><input type="submit" id="button" value="Release the moles!" tabindex="3" /></p>
</form>';

if (!empty($_POST['dwam-domain'])) {
  $domain = htmlentities(trim($_POST['dwam-domain']));
  $output = '';

  echo "\n" .'<h2>' . $domain . '</h2>';

  if (checkdnsrr($domain, 'A')) {
    if ($servers = @file_get_contents('servers.json')) {
      if ($servers = json_decode($servers, true)) {
        foreach ($servers as $provider => $properties) {
          $resolver = new Net_DNS2_Resolver(array('nameservers' => array($properties['primary'], $properties['secondary'])));

          try {
            $answer = $resolver->query($domain, 'A');

            if ($answer->answer) {
              $info = $answer->answer[0]->address;
            }
          } catch (Exception $e) {
            switch ($e->getCode()) {
              case 0:
                $info= 'Undefined error';
                break;
              case 5:
                $info = 'Operation refused';
                break;
              case 202:
                $info= 'Operation timed out';
                break;
            };
          }

          $info = !isset($info) ? 'Undefined error' : $info;

          $output .= "\n  "
            . '<li>'
            . '<img src="ui/imgs/' . $properties['location'] . '.png" alt="[' . $properties['location'] . ']" /> '
            . '<span class="provider">' . $provider . '</span> '
            . '<span class="answer">' . $info . '</span>'
            . '</li>';

          unset($info);
        }

        echo "\n\n" .'<ul id="results">' . $output . "\n" . '</ul>';
      } else {
        echo '<p>Error: servers.json is not a valid JSON file</p>';
      }
    } else {
      echo '<p>Error: cannot read servers.json</p>';
    }
  } else {
    echo '<p>Error: invalid domain name</p>';
  }
} else {
  echo $form;
}

?>


<p id="footer">Powered by <a href="https://github.com/alct/dwam">DWaM</a>.</p>
</body>
</html>