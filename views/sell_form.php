<form action="sell.php" method="post">
    <fieldset>
        
        <div class="form-group">
            <select class="form-control" name="stockSelect" style = "width: 100px">
                
                 <option disabled selected value="">Symbol</option>
                
                <?php foreach ($stockList as $stock): ?>
                    <option value = "<?= $stock ?>" > <?= $stock ?> </option>
                <?php endforeach ?>
                
            </select>
        </div>
        
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                Sell
            </button>
        </div>
    
    </fieldset>
</form>