
var UserManagement = function() {
};

UserManagement.prototype.setUsers = function(users) {
    var s = '<form name="users">';
    for(var i=0;i<users.length;i++){
        $user = users[i];
        $nameAndLockedState = $user.name + ' ' + $user.isLocked;
        s += '<input type="checkbox" name="u" value="' + $user.name + '">' + $nameAndLockedState + '</input>';
        s += '<br>';
    }
    s+= '</form>';

    $('#userManagement').html(s);
}
