DlgLogin = function (opts) {
    var me = this;

    me._usernameID = uuid();
    me._passwordID = uuid();

    me._dlg = $("#" + opts.div).html(
            "   <label>用户名</label><br>"
            + " <input id='" + me._usernameID + "' class='ui-corner-all' type='text'/><br>"
            + " <label>密码</label><br>"
            + " <input id='" + me._passwordID + "' class='ui-corner-all' type='password'/>"
            ).dialog({
        height: 250,
        width: 350,
        modal: true,
        buttons: [{
                text: "登录",
                click: function () {
                    me._onLogin();
                }
            }, {
                text: "注册",
                click: function () {
                    new DlgRegister({
                        div: "dlg1",

                    });
                    //         me._dlg.dialog("close");

                }
            }]
    });
};


DlgLogin.prototype._onLogin = function () {
    var me = this;

    Connector({
        data: {
            type: "USER_LOGIN",
            params: {
                username: $("#" + me._usernameID).val(),
                password: $("#" + me._passwordID).val()
            }
        },
        success: function (json) {
            //  me._dlg.dialog("close");
            // show friends list
            alert(json.message);
            me._dlg.dialog("close");
            new DlgFriends({
                div: "dlg2",
                username: $("#" + me._usernameID).val()
            });
        },
        failure: function (json) {
            alert(json.message);
        }
    });
};





