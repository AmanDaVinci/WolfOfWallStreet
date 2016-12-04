<?php

    // configuration
    require("../includes/config.php");
    
    // Get the portfolio details of the logged in user
    $user_id = $_SESSION["id"];
    $rows = CS50::query("SELECT * FROM portfolio WHERE user_id = ?", $user_id);
    $cash = CS50::query("SELECT cash FROM users WHERE id = ?", $user_id);
    
    $positions = [];
    
    if ($rows == false || $cash == false)
    {
        
        // render portfolio when no stocks are bought
        render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "cash" => $cash]);

    }
    else
    {
        // Package the portfolio
        foreach ($rows as $row)
        {
            $stock = lookup($row["symbol"]);
            if ($stock !== false)
            {
                $positions[] = [
                    "name" => $stock["name"],
                    "price" => number_format($stock["price"], 2),
                    "shares" => $row["shares"],
                    "symbol" => $row["symbol"],
                    "total" => number_format($row["shares"] * $stock["price"], 2)
                ];
            }
        }
    }
    
    // render portfolio
    render("portfolio.php", ["positions" => $positions, "title" => "Portfolio", "cash" => $cash]);

?>