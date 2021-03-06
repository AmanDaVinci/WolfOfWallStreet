<div class = "table-responsive">
    <!--<iframe allowfullscreen frameborder="0" height="315" src="https://www.youtube.com/embed/oHg5SJYRHA0?autoplay=1&iv_load_policy=3&rel=0" width="420"></iframe>-->
    <table class="table table-striped">
        
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Name</th>
                <th>Shares</th>
                <th>Price</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($positions as $position): ?>
        
            <tr class="text-left">
                <td><?= $position["symbol"] ?></td>
                <td><?= $position["name"] ?></td>
                <td><?= $position["shares"] ?></td>
                <td>$<?= $position["price"] ?></td>
                <td>$<?= $position["total"] ?></td>
            </tr>
            
            <?php endforeach ?>
            
            <tr class="text-left"> 
                <td colspan="4">CASH BALANCE</td>
                <td>$<?= $cash[0]["cash"]?></td>
            </tr>
        
        </tbody>
    
    </table>
</div>
