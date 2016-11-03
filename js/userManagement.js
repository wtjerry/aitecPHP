
var UserManagement = function() {
    $('#unlockButton').live('click', this.unlockClicked.bind(this));
    $('#lockButton').live('click', this.lockClicked);
};

UserManagement.prototype.setUsers = function(users) {
    $("#users").empty();
    
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
    $("input[type=checkbox]")
        .filter(function(index) {
            return this.checked;
        })
        .each(function(){
            users.push(this.id);
        });

    var data = { "users" : users };
    $.chatPOST('unlockUsers',data,function(r){
        if(r.error){
            chat.displayError(r.error);
        }
        else chat.displaySuccess("Successfully unlocked users.");
    });
};

UserManagement.prototype.lockClicked = function() {
    var users = new Array();
    $("input[type=checkbox]")
        .filter(function(index) {
            return this.checked;
        })
        .each(function(){
            users.push(this.id);
        });

    var data = { "users" : users };
    $.chatPOST('lockUsers',data,function(r){
        if(r.error){
            chat.displayError(r.error);
        }
        else chat.displaySuccess("Successfully locked users.");
    });
};

