<?php
    // configuration
    require("../includes/config.php"); 
    
    // Get the logged in user id
    $user_id = $_SESSION["id"];
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // List of stock to display
        $stocks = CS50::query("SELECT symbol FROM portfolio where user_id = ?", $user_id);
        if ($stocks != NULL)
        {
            $stockList = [];
            foreach($stocks as $stock)
            {
                $stockList[] = $stock["symbol"];
            }
            // render sell form
            render("sell_form.php", ["title" => "Sell", "stockList" => $stockList]);
        }
    }
    
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["stockSelect"]))
        {
            apologize("You must select a stock to sell it.");
        }

        // Get the shares owned by user
        $stockToSell = $_POST["stockSelect"];
        $shareCount = CS50::query("SELECT shares FROM portfolio WHERE user_id = ? AND symbol = ?", $user_id, $stockToSell);
        
        // stock must exist
        if($shareCount == NULL)
        {
            apologize("You do not seem to have any shares of this stock.");
        }
        $shareCount = $shareCount[0]["shares"];
        
        // lookup the stock symbol for current price
        $stock = lookup($stockToSell);
        
        if($stock == false)
        {
            apologize("Stock symbol not found.");
        }
        // Get the stock price
        $stockPrice = number_format($stock["price"],2);
        
        // Determining the deposit
        $deposit = $shareCount * $stockPrice;
        
        // Begin Transaction 
        // TODO: Must use SQL transaction to make it more secure
        $sellStock = CS50::query("DELETE FROM portfolio WHERE user_id = ? AND symbol = ?", $user_id, $stockToSell);
        $depositCash = CS50::query("UPDATE users SET cash = cash + ? WHERE id = ?", $deposit, $user_id);
        
        // Transaction failed
        if($sellStock == NULL || $depositCash == NULL)
        {
            apologize("Transaction failed. Please contact admin.");
        }
        
        // Update history
        $sellTime = date('d/m/y, g:i:s A');
        $historyUpdate = CS50::query("INSERT INTO history (user_id, symbol, shares, transaction, price, date)
                                        VALUES (?, ?, ?, ?, ?, ?)", $user_id, $stockToSell, $shareCount, 'SELL', $stockPrice, $sellTime); 
        // redirect to portfolio
        redirect("/");
    }
?>