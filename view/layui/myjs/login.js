var loginUrl = 'https://192.168.10.10:9999/';

function check_login() {
    var name = $("#user_name").val();
    var pass = $("#password").val();
    if (name === null || name === '' || pass === null || pass === '') {
        $("#login_form").removeClass('shake_effect');
        setTimeout(function () {
            $("#login_form").addClass('shake_effect')
        }, 1);
        return false;
    }
    $.post(loginUrl + 'Api/Login/login', {username: name, password: pass}, function (data) {
        console.log(data.code);
        if (data.code === 200) {
            alert(data.msg);
            //缓存token
            localStorage.setItem('uid', data.result.id); //缓存uid
            //跳转首页
            var panduan = isPc();
            if (panduan === 'pc') {
                location.href = './pc/index.html';
            } else {
                location.href = './mobile/index.html';
            }
        } else if (data.code === 202) {
            alert(data.msg);
        }
    })
}

function check_register() {
    var name = $("#r_user_name").val();
    var pass = $("#r_password").val();
    var email = $("#r_email").val();
    if (name == "" && pass == "" && email == "") {
        $("#login_form").removeClass('shake_effect');
        setTimeout(function () {
            $("#login_form").addClass('shake_effect')
        }, 1);
        return false;
    }
    $.post(loginUrl + 'Api/Login/register', {username: name, password: pass, email: email}, function (data) {
        console.log(data.code);
        if (data.code === 200) {
            alert(data.msg);
            location.reload();
        } else {
            alert(data.msg);
        }
    })
}

$(function () {
    $("#create").click(function () {
        check_register();
        return false;
    });
    $("#login").click(function () {
        check_login();
        return false;
    });
    $('.message a').click(function () {
        $('form').animate({
            height: 'toggle',
            opacity: 'toggle'
        }, 'slow');
    });
});


function isPc() {
    //平台、设备和操作系统
    var system = {
        win: false,
        mac: false,
        xll: false,
        ipad: false
    };
    //检测平台
    var p = navigator.platform;
    system.win = p.indexOf("Win") == 0;
    system.mac = p.indexOf("Mac") == 0;
    system.x11 = (p == "X11") || (p.indexOf("Linux") == 0);
    system.ipad = (navigator.userAgent.match(/iPad/i) != null) ? true : false;
    //跳转语句，如果是手机访问就自动跳转到wap.baidu.com页面
    if (system.win || system.mac || system.xll || system.ipad) {
        return 'pc';
    } else {
        return 'mobile';
    }
}