<!DOCTYPE html>

<?php
function personal($display, $given, $sn) {
    // check if passwords are provided
    if (empty($display) && empty($given) && empty($sn)) {
        exit('No new information provided.');
    }
    // user CN
    $user = $_SESSION["user"];
    $cn = "cn=".$user.",ou=people,dc=nnbox,dc=org";

    // admin user
    $ldap = connect();
    $ldap_manager = "uid=manager,ou=services,dc=nnbox,dc=org";
    $ldap_password = "";

    $bind = ldap_bind($ldap, $ldap_manager, $ldap_password);

    if ($bind) {
        $info = array(
                "cn" => $user,
                "displayName" => $display,
                "givenName" => $given,
                "sn" => $sn
        );

        if ($modify = ldap_modify($ldap, $cn, $info)) {
            echo "The information has been updated.";
        }
        else {
            echo "An unexpected error occurred.";
        }

    }
    else {
        echo "Couldn't bind to the LDAP server.";
    }
}
// check updated variables
$display = "";
$given = "";
$sn = "";

if (isset($_POST["display"])) {
    $display = $_POST["display"];
}

if (isset($_POST["given"])) {
    $display = $_POST["given"];
}

if (isset($_POST["sn"])) {
    $display = $_POST["sn"];
}

// call the function
personal($display, $given, $sn);

?>

<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Account Management | NoNameBox</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="assets/big-picture/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link href="assets/big-picture/css/main.css" type="text/css" rel="stylesheet" />
    <link href="assets/big-picture/css/nnb_custom.css" type="text/css" rel="stylesheet" />
    <link href="assets/css/custom.css" type="text/css" rel="stylesheet" />

  </head>
  <body>
    <header id="header">
      <h1 id="logo"><a href="/"> <img src="assets/img/gus_nnblogo.png" alt="No Name Box" class="header-logo"></a></h1>
      <nav id="nav">
          <ul>
              <li><a href="http://nonamebox.org/">Get back to the site</a></li>
          </ul>
      </nav>
    </header>

    <div class="container">
      <div class="row">
          <div class="col-md-4" >
            <ul class="nav nav-pills nav-stacked nav-bracket">
              <li class="nav-item"><a href="/" title="Home" class="nav-link"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
              <li class="nav-item"><a><a href="personal-information.php" title="Home" class="nav-link active"><i class="fa fa-user" aria-hidden="true"></i>Personal Information</a></a></li>
              <li class="nav-item"><a><a href="password.php" title="Home" class="nav-link"><i class="fa fa-lock" aria-hidden="true"></i>Password</a></a></li>
            </ul>
          </div>
          <div class="col-md-8">
            <h1>Account Manager</h1>
            <h2>Personal Information</h2>
            <div class="row">
              <p>Here you can modify information on your account. All services on NoNameBox (mail, cloud...) use the same user information, password and login. So you only have to remember one password!</p>
              <hr>
              <div class="container content">
                <form action="#" method="post">

                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label><strong>Display Name:</strong></label>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="display" value="" placeholder="The name you want people to see"/>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label><strong>Given Name:</strong></label>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="given" value="" placeholder="Your actual name"/>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label><strong>Surnames:</strong></label>
                        </div>
                        <div class="col-md-6">
                          <input type="text" name="sn" value="" placeholder="Your surnames"/>
                        </div>
                      </div>
                  </div>

                  <div class="form-group">
                    <input type="submit" value="Submit" class="nnb_submit">
                  </div>

                </form>
              </div>
            </div>
          </div>
      </div>
    </div>

    <footer id="footer">
      <ul class="actions">
          <li><a href="https://t.me/NoNameBox" class="icon fa-telegram"></a></li>
          <li><a href="mailto:info@nonamebox.org" class="icon fa-envelope"></a></li>
      </ul>
    </footer>

    <script src="assets/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
  </body>
</html>
