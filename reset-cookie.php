<?php
// Set the cookie with an empty value and a negative expiration time
if(isset($_COOKIE['displayedMessages'])) {
    setcookie('displayedMessages', '', time() - 3600);
}