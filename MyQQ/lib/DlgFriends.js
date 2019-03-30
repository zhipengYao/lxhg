DlgFriends = function (opts) {
    var me = this;
    //获取自己的用户名
    me._username = opts.username;    
    //根据好友的数目动态生成显示
    me._div = opts.div;
    me._getFriends();   
    //当做好PHP端来到这里，以为很快就能搞定了，个把小时后我仿佛听到了盼盼说到：“呵，天真。”
    //调试好多次，无法达到想要的效果，只能把下面这一段放到me._getFriends()里面去执行
    /*
     me._dlg2 = $("#" + opts.div).html(
     "<label>你的好友如下：</label><br>"
     + "<ol>"
     + me._json
     + "</ol>"
     ).dialog({
     height: 400,
     width: 550,
     modal: true,
     buttons: [{
     text: "关闭",
     click: function () {
     me._dlg2.dialog("close");
     }
     }]
     });
     */


};

DlgFriends.prototype._getFriends = function () {
    var me = this;
    me.html = "";
    Connector({

        data: {
            type: "USER_Friends",
            params: {
                username: me._username
            }
        },
        success: function (json) {
            //    alert(json.message + ":" + json.data[0] + "," + json.data[1] + "," + json.data[2]);
            var str;
            for (var i = 1; i <= json.data[0]; i++) {
                str = "<li>" + json.data[i] + "</li>";
                me.html = me.html + str;
            }
            me._dlg2 = $("#" + me._div).html(
                    "<label>你的好友如下：</label><br>"
                    + "<ol>"
                    + me.html
                    + "</ol>"
                    ).dialog({
                height: 400,
                width: 550,
                modal: true,
                buttons: [{
                        text: "关闭",
                        click: function () {
                            me._dlg2.dialog("close");
                            new DlgLogin({
                                div: "dlg"
                            });
                        }
                    }]
            });
        },
        failure: function (json) {
            alert(json.message);
        }
    });

};
