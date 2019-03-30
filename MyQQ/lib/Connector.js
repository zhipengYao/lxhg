
/**
 * 
 * @returns {undefined}
 * Connector({
 *  url: "",
 *  data:{
 *      type: "",
 *      params:{
 *        username:"",
 *        password:""  
 *      }
 *  },
 *  success:function(json){
 *  },
 *  failure:function(json){
 *  }
 * })
 */

Connector = function (opts) {
    var me = this;
    me._opts = $.extend({
        url: "php/MyQQServer.php"
    }, opts);
    if (me._opts.data.type === "USER_LOGIN") {

        $.ajax({
            url: me._opts.url,
            method: "POST",
            data: {
                request: JSON.stringify(me._opts.data)
            },
            success: function (data) {
                var json = JSON.parse(data);
                if (json.success) {
                    if (me._opts.success) {
                        me._opts.success(json);
                    } else {
                        alert(json.message);
                    }
                } else {
                    if (me._opts.failure) {
                        me._opts.failure(json);
                    } else {
                        alert(json.message);
                    }
                }
            },
            error: function (data) {
                alert("网络异常");
            }

        });
    }
    if (me._opts.data.type === "USER_Register") {
        //用于覆盖原来的链接，可有可无
        opts = {
            url: "php/MyQQServer.php"
        };
        
        //发送接收数据
        $.ajax({
            url: me._opts.url,
            method: "POST",
            data: {
                request: JSON.stringify(me._opts.data)
            },
            success: function (data) {
                var json = JSON.parse(data);
                if (json.success) {
                    if (me._opts.success) {
                        me._opts.success(json);
                    } else {
                        alert(json.message);
                    }
                } else {
                    if (me._opts.failure) {
                        me._opts.failure(json);
                    } else {
                        alert(json.message);
                    }
                }
            },
            error: function (data) {
                alert("网络异常");
            }

        });
    }
    
    if (me._opts.data.type === "USER_Friends") {
         //用于覆盖原来的链接，可有可无
        opts = {
            url: "php/MyQQServer.php"
        };
        
        //发送接收数据
        $.ajax({
            url: me._opts.url,
            method: "POST",
            data: {
                request: JSON.stringify(me._opts.data)
            },
            success: function (data) {
                var json = JSON.parse(data);
                if (json.success) {
                    if (me._opts.success) {
                        me._opts.success(json);
                    } else {
                        alert(json.message);
                    }
                } else {
                    if (me._opts.failure) {
                        me._opts.failure(json);
                    } else {
                        alert(json.message);
                    }
                }
            },
            error: function (data) {
                alert("网络异常");
            }

        });
        
        
    }


};



