layui.define(['jquery', 'contextMenu', 'layer'], function (exports) {
    var contextMenu = layui.contextMenu;
    var $ = layui.jquery;
    var layer = layui.layer;
    var conf = {
        uid: uid, //
        layim: null,
    };
    var coreUrl = 'http://123.207.92.250:9999/';
    var core = {
        right: function () {
            //好友右键
            $(".layim-list-friend >li > ul > li").contextMenu({
                width: 140, // width
                itemHeight: 30, // 菜单项height
                bgColor: "#fff", // 背景颜色
                color: "#333", // 字体颜色
                fontSize: 15, // 字体大小
                hoverBgColor: "#009bdd", // hover背景颜色
                hoverColor: "#fff", // hover背景颜色
                target: function (ele) { // 当前元素
                    $(".ul-context-menu").attr("data-id", ele[0].id);
                    $(".ul-context-menu").attr("data-name", ele.find("span").html());
                    $(".ul-context-menu").attr("data-img", ele.find("img").attr('src'));
                },
                menu: [
                    { // 菜单项
                        text: "发送消息",
                        icon: "",
                        callback: function (ele) {
                            var othis = ele.parent(),
                                friend_id = othis[0].dataset.id.replace(/^layim-friend/g, ''),
                                friend_name = othis[0].dataset.name,
                                friend_avatar = othis[0].dataset.img;
                            conf.layim.chat({
                                name: friend_name
                                , type: 'friend'
                                , avatar: friend_avatar
                                , id: friend_id
                            });
                        }
                    },
                    {
                        text: "查看资料",
                        icon: "",
                        callback: function (ele) {
                            var othis = ele.parent(), friend_id = othis[0].dataset.id.replace(/^layim-friend/g, '');
                            im.getInformation({
                                id: friend_id,
                                type: 'friend'
                            });
                        }
                    },
                    {
                        text: "聊天记录",
                        icon: "",
                        callback: function (ele) {
                            var othis = ele.parent(),
                                friend_id = othis[0].dataset.id.replace(/^layim-friend/g, ''),
                                friend_name = othis[0].dataset.name;
                            im.getChatLog({
                                name: friend_name,
                                id: friend_id,
                                type: 'friend'
                            });
                        }
                    },
                    {
                        text: "修改备注",
                        icon: "&#xe602;",
                        callback: function (ele) {
                            var othis = ele.parent(), friend_id = othis[0].dataset.id.replace(/^layim-friend/g, ''),
                                friend_name = othis.data('name');
                            layer.prompt({title: '修改备注', formType: 0, value: friend_name}, function (remarks, toId) {
                                $.get(url + 'Setting/remarksSave', {
                                    remarks: remarks,
                                    toId: toId,
                                    uid: uid
                                }, function (res) {
                                    console.log(res.msg);
                                    if (res.statusCode === 200) {
                                        var friendName = $("#layim-friend" + friend_id).find('span');
                                        friendName.html(res.msg);
                                        layer.close(toId);
                                    }
                                    layer.msg(res.msg);
                                });
                            });
                        }
                    },
                    {
                        text: "删除好友",
                        icon: "&#xe640;",
                        callback: function (ele) {
                            alert('删除好友');
                        }
                    },
                    {
                        text: "移动分组",
                        icon: "&#xe630;",
                        callback: function (ele) {
                            alert('移动分组');
                        }
                    }
                ]
            });
            //分组右键
            $(".layim-list-friend >li > h5").contextMenu({
                width: 140, // width
                itemHeight: 30, // 菜单项height
                bgColor: "#fff", // 背景颜色
                color: "#333", // 字体颜色
                fontSize: 15, // 字体大小
                hoverBgColor: "#009bdd", // hover背景颜色
                hoverColor: "#fff", // hover背景颜色
                target: function (ele) { // 当前元素
                    $(".ul-context-menu").attr("data-id", ele[0].id);
                    $(".ul-context-menu").attr("data-name", ele.find("span").html());
                    $(".ul-context-menu").attr("data-img", ele.find("img").attr('src'));
                },
                menu: [
                    { // 菜单项
                        text: "添加分组",
                        icon: "&#xe654;",
                        callback: function (ele) {
                            var othis = ele.parent(),
                                friend_id = othis[0].dataset.id.replace(/^layim-friend/g, '');

                        }
                    },
                    {
                        text: "重命名",
                        icon: "&#xe642;",
                        callback: function (ele) {
                            var othis = ele.parent(), mygroupIdx = othis.data('id'), groupName = othis.data('name');
                            console.log(othis.data());
                        }
                    },
                    {
                        text: "删除该组",
                        icon: "&#x1006;",
                        callback: function (ele) {
                            alert('删除该组');
                        }
                    }
                ]
            });
        },
        config: function (options) {
            conf = $.extend(conf, options);
            this.register();
        },

        register: function () {
            var layim = conf.layim;
            if (layim) {
                console.log('core页面uid = ' + conf.uid);
                //更新签名
                layim.on('sign', function (sign) {
                    $.get(coreUrl+'Index/autograph', {sign: sign, uid: uid})
                });
                //好友分组面板
                function addFriends(data) {
                    layim.setFriendGroup({
                        type: 'friend'
                        ,username: data.data.username //好友昵称，若申请加群，参数为：groupname
                        ,avatar: data.data.avatar //头像
                        ,group: layim.cache().friend //获取好友列表数据
                        ,submit: function(group, index){
                            //同意或者不同意
                            console.log(group);
                            layim.addList(data); //见下文
                        }
                    });
                }

                var socket = new WebSocket('ws://123.207.92.250:9999');
                socket.onopen = function () {
                    //发送消息 绑定fd
                    socket.send(JSON.stringify({
                        controller: 'message'
                        , action: 'bind'
                        , data: {
                            uid: localStorage.getItem("uid")
                        }
                    }));
                    console.log('socket 链接成功 当前用户uid = ' + localStorage.getItem("uid"));
                };
                //socket发消息
                layim.on('sendMessage', function (res) {
                    //监听到上述消息后，就可以轻松地发送socket了，如：
                    res.uid = uid;
                    socket.send(JSON.stringify({
                        controller: 'message'
                        , action: 'chatMessage'
                        , data: res
                    }));
                });
                //socket收消息
                socket.onmessage = function (res) {
                    var data = JSON.parse(res.data);
                    switch (data['msgType']) {
                        case 'chatMessage':
                            console.log('chatMessage 事件');
                            layim.getMessage(data.data);
                            break;
                        case 'logout':
                            alert('会话已过期，请重新登录!');
                            localStorage.removeItem('uid');
                            location.href = '../login.html';
                            break;
                        case 'addFriendEvent':
                            console.log(data.data.username+'加好友了');
                            addFriends(data);
                            break;
                    }
                };
            }
        },
    };


    // layui 语法
    exports('core', core);
});