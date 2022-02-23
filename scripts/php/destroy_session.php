<?php
  session_start();
  //destroy the users session.
  $_SESSION = array();
  setcookie(session_name(), '', time() - 2592000, '/');
  session_destroy();

  //navigate to Home
  header("Location: ../../?return=sess_end");
?>