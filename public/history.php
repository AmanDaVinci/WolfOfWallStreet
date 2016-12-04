<?php

    // configuration
    require("../includes/config.php");
    
    // Get the portfolio details of the logged in user
    $user_id = $_SESSION["id"];
    $historyList = CS50::query("SELECT * FROM history WHERE user_id = ?", $user_id);
    
    // render portfolio
    render("history_view.php", ["title" => "History", "historyList" => $historyList]);

?>