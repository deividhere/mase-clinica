<?php
  // $_COOKIE["persistentLogin"] = true;
  // $_COOKIE["email"] = $emailLogin;
  // $_COOKIE["nume"] = $queryNume;
  // $_COOKIE["prenume"] = $queryPrenume;
  if (isset($_COOKIE["persistentLogin"]) && $_COOKIE["persistentLogin"] && !isset($_SESSION["loggedin"])) {
    // user checked remember me, but session expired

    $uniqueId = $_COOKIE["uniqueId"];
    $email = $_COOKIE["email"];

    include "$rootDir/sqlinit.php";

    // Create connection
    $mysqli = new mysqli($servername, $username, $password, $database);

    // Set autocommit to off
    $mysqli->autocommit(FALSE);

    // Start transaction
    $mysqli->begin_transaction();

    // Check connection
    if ($mysqli->connect_error) {
      die("Conectarea la baza de date a eșuat: " . $mysqli->connect_error);
    }

    $sql = "SELECT email FROM persistentlogin WHERE uniqueid = ?";
    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $uniqueId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = mysqli_fetch_assoc($result);
      
      $queryEmail = $row["email"];

      if (!strcmp($queryEmail, $email)) {
        // email is good, login
        $_SESSION["loggedin"] = true;
        $_SESSION["email"] = $email;
        $_SESSION["userType"] = $_COOKIE["userType"];
        $_SESSION["nume"] = $_COOKIE["nume"];
        $_SESSION["prenume"] = $_COOKIE["prenume"];
      }
      else {
        // email is not good, delete cookies
        unset($_COOKIE["persistentLogin"]);
        unset($_COOKIE["email"]);
        unset($_COOKIE["nume"]);
        unset($_COOKIE["prenume"]);
        unset($_COOKIE["uniqueId"]);
        unset($_COOKIE["userTpye"]);
        unset($_COOKIE["userId"]);

        setcookie('persistentLogin', '', time() - 3600, '/');
        setcookie('email', '', time() - 3600, '/');
        setcookie('nume', '', time() - 3600, '/');
        setcookie('prenume', '', time() - 3600, '/');
        setcookie('uniqueId', '', time() - 3600, '/');
        setcookie('userTpye', '', time() - 3600, '/');
        setcookie('userId', '', time() - 3600, '/');
      }
    }
    else {
      // user was not found in persistentlogin table, remove cookies
      unset($_COOKIE["persistentLogin"]);
      unset($_COOKIE["email"]);
      unset($_COOKIE["nume"]);
      unset($_COOKIE["prenume"]);
      unset($_COOKIE["uniqueId"]);
      unset($_COOKIE["userTpye"]);
      unset($_COOKIE["userId"]);

      setcookie('persistentLogin', '', time() - 3600, '/');
      setcookie('email', '', time() - 3600, '/');
      setcookie('nume', '', time() - 3600, '/');
      setcookie('prenume', '', time() - 3600, '/');
      setcookie('uniqueId', '', time() - 3600, '/');
      setcookie('userTpye', '', time() - 3600, '/');
      setcookie('userId', '', time() - 3600, '/');
    }

    $stmt->execute();
    $mysqli->close();
  }
?>