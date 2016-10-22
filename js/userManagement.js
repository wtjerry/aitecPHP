
var UserManagement = function() {
    $('#unlockButton').live('click', this.unlockClicked.bind(this));
    $('#lockButton').live('click', this.lockClicked);
};

UserManagement.prototype.setUsers = function(users) {
    for(var i=0;i<users.length;i++){
        $user = users[i];

        $("#users")
            .append(
                $('<div>', { id : $user.name })
                .text($user.name)
            );

        $("#" + $user.name)
            .append(
                $('<input>', { id : $user.name, type:"checkbox", name: $user.name + "UserCheckbox"})
            );
    }
};

UserManagement.prototype.unlockClicked = function() {
    var users = new Array();
    $("input[type=checkbox]").each(function(){
        var dict = {
            "username" : this.id,
            "shouldBeChanged" : this.checked
        };
        users.push(dict);
    });

    var data = { "users" : users };
    $.chatPOST('unlockUsers',data,function(r){
    });
};

UserManagement.prototype.lockClicked = function() {
    var users = new Array();
    $("input[type=checkbox]").each(function(){
        var dict = {
            "username" : this.id,
            "shouldBeChanged" : this.checked
        };
        users.push(dict);
    });

    var data = { "users" : users };
    $.chatPOST('lockUsers',data,function(r){
    });
};

