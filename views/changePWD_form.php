<form action="changePWD.php" method="post">
    <fieldset>
        
        <div class="form-group">
            <input autocomplete="off" autofocus class="form-control" name="currPWD" placeholder="Current Password" type="password"/>
        </div>
        
        <br>
        
        <div class="form-group">
            <input class="form-control" name="newPWD" placeholder="New Password" type="password"/>
        </div>
        
        
        <div class="form-group">
            <input class="form-control" name="confirmation" placeholder="Confirm New Password" type="password"/>
        </div>
        
        <div class="form-group">
            <button class="btn btn-default" type="submit">
                Change Password
            </button>
        </div>
    
    </fieldset>
</form>