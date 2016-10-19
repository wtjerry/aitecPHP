
var UserManagement = function() {
};

UserManagement.prototype.setUsers = function(users) {

    var checkboxes = [];
    for(var i=0;i<users.length;i++){
        $user = users[i];
        $nameAndLockedState = $user.name + ' ' + $user.isLocked;
        var s = '<input type="checkbox" name="u" value="' + $user.name + '">' + $nameAndLockedState + '</input>';
        checkboxes.push(s);
    }

    var unlockButton = '<input type="submit" class="blueButton" value="Unlock checked users" />';
    var lockButton = '<input type="submit" class="blueButton" value="Lock checked users" />';
    var html = checkboxes.join('<br>') + '<br>' + unlockButton + lockButton;

    $('#users').html(html);
}
