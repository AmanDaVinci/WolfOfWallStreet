<?php

    // configuration
    require("../includes/config.php"); 
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render quote form
        render("quote_form.php", ["title" => "Quote"]);
    }
    
    // else if user reached page via POST (as by submitting quote form via POST)
    else if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // Validate the quote form
        if(empty($_POST["symbol"]))
        {
            apologize("You must provide a symbol.");
        }
        
        // lookup the stock symbol
        $stock = lookup($_POST["symbol"]);
        
        // symbol lookup failed
        if($stock == false)
        {
            apologize("Symbol not found.");
        }
        
        // Get the symbol, name and price
        $symbol = $stock["symbol"];
        $name = $stock["name"];
        $price = number_format($stock["price"],2);
        
        $result = "A share of {$name} ({$symbol}) costs \${$price}.";
        
        // Render the result page
        render("quote_result.php", ["result" => $result]);
    }
    
    
?>