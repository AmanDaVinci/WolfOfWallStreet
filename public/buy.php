<?php
    // configuration
    require("../includes/config.php"); 
    
    // Get the logged in user id
    $user_id = $_SESSION["id"];
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        //render the buy form
        render("buy_form.php", ["title" => "Buy"]);
    } 
    
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["stock"]))
        {
            apologize("You must specify a stock to buy.");
        }
        if (empty($_POST["shares"]))
        {
            apologize("You must specify a number of shares.");
        }
        
        // Users can only buy whole shares of stocks
        if(!preg_match("/^\d+$/", $_POST["shares"]))
        {
            apologize("Invalid number of shares.");
        }
        
        // Get the valid data
        $stockToBuy = strtoupper($_POST["stock"]);
        $sharesToBuy = $_POST["shares"];
        
        // lookup the stock symbol for current price
        $stock = lookup($stockToBuy);
        if($stock == false)
        {
            apologize("Stock symbol not found.");
        }
        $stockPrice = number_format($stock["price"],2);
        
        $cost = $sharesToBuy * $stockPrice;
        
        // User must be able to afford the shares
        $cash = CS50::query("SELECT cash FROM users WHERE id = ?", $user_id);
        if ($cash < $cost)
        {
            apologize("You can't afford that.");
        }
        
        $buy = CS50::query("INSERT INTO portfolio (user_id, symbol, shares) VALUES(? , ? , ?) 
                    ON DUPLICATE KEY UPDATE shares = shares + ?", $user_id, $stockToBuy, $sharesToBuy, $sharesToBuy);
        $debit = CS50::query("UPDATE users SET cash = cash - ? WHERE id = ?", $cost, $user_id);
        
        // Transaction failed.
        if( $buy == NULL || $debit == NULL)
        {
            apologize("Transcation failed. Please contact admin.");
        }
        
        // redirect to portfolio
        redirect("/");
    }
?>