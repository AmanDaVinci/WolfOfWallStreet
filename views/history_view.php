<div class = "table-responsive">
    <!--<iframe allowfullscreen frameborder="0" height="315" src="https://www.youtube.com/embed/oHg5SJYRHA0?autoplay=1&iv_load_policy=3&rel=0" width="420"></iframe>-->
    <table class="table table-striped">
        
        <thead>
            <tr>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Transaction</th>
                <th>Price</th>
                <th>Date/Time</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($historyList as $history): ?>
        
            <tr class="text-left">
                <td><?= $history["symbol"] ?></td>
                <td><?= $history["shares"] ?></td>
                <td><?= $history["transaction"] ?></td>
                <td>$<?= $history["price"] ?></td>
                <td><?= $history["date"] ?></td>
            </tr>
            
            <?php endforeach ?>
            
        </tbody>
    
    </table>
</div>
