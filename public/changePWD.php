<?php
    // configuration
    require("../includes/config.php"); 
    
    // Get the logged in user id
    $user_id = $_SESSION["id"];
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render forgot password form
        render("changePWD_form.php", ["title" => "ChangePassword"]);
    }
        // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["currPWD"]))
        {
            apologize("You must provide your current password.");
        }
        else if (empty($_POST["newPWD"]) || empty($_POST["confirmation"]) )
        {
            apologize("You must confirm your password by entering it twice.");
        }
        if ($_POST["newPWD"] != $_POST["confirmation"])
        {
            apologize("New Passwords do not match.");
        }
        
        $currPWD = $_POST["currPWD"];
        $newPWD = $_POST["newPWD"];
        
        // validate current password
        $rows = CS50::query("SELECT * FROM users WHERE id = ?", $user_id);
        if (password_verify($currPWD, $rows[0]["hash"]))
        {
            $updatePWD = CS50::query("UPDATE users SET hash = ? WHERE id = ?", password_hash($newPWD, PASSWORD_DEFAULT), $user_id);
            
            // check for update and inform user
            if ($updatePWD != NULL)
            {
                // render successfull update
                render("changePWDsuccess.php", ["title" => "PasswordChangeSuccessfull"]);
            }
            else
            {
                apologize("Could not change password. Please try again.");
            }
        }

    }
?>