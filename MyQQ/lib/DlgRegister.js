DlgRegister = function (opts) {
    var me = this;

    me._usernameID = uuid();
    me._passwordID = uuid();
    me._repasswordID = uuid();
    me._emailID = uuid();
    me._telephoneID = uuid();

    me._dlg1 = $("#" + opts.div).html(
            "   <label>用户名</label><br>"
            + " <input id='" + me._usernameID + "' class='ui-corner-all' type='text'/><br>"
            + " <label>密码</label><br>"
            + " <input id='" + me._passwordID + "' class='ui-corner-all' type='text'/>"
            + "   <label>重复密码</label><br>"
            + " <input id='" + me._repasswordID + "' class='ui-corner-all' type='password'/><br>"
            + " <label>邮箱地址</label><br>"
            + " <input id='" + me._emailID + "' class='ui-corner-all' type='text'/>"
            + " <label>电话号码</label><br>"
            + " <input id='" + me._telephoneID + "' class='ui-corner-all' type='text'/>"
            ).dialog({
        height: 400,
        width: 550,
        modal: true,
        buttons: [{
                text: "注册",
                click: function () {
                    me._onRegister();
                }
            }, {
                text: "取消",
                click: function () {
                    me._dlg1.dialog("close");
                }
            }]
    });
};


DlgRegister.prototype._onRegister = function () {
    var me = this;

    Connector({

        data: {
            type: "USER_Register",
            params: {
                username: $("#" + me._usernameID).val(),
                password: $("#" + me._passwordID).val(),
                repassword: $("#" + me._repasswordID).val(),
                email: $("#" + me._emailID).val(),
                telephone: $("#" + me._telephoneID).val()
            }
        },
        success: function (json) {
            //  me._dlg1.dialog("close");
            // show friends list
            if (json.success) {
                alert(json.message);
                me._dlg1.dialog("close");

            }
        },
        failure: function (json) {
            alert(json.message);
        }
    });


}

