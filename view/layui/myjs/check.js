var uid = localStorage.getItem("uid");//获取名称为“key”的值
var url = 'http://123.207.92.250:9999/Api/';
console.log('用户uid = ' + uid);
if (uid === undefined || uid === '' || uid === null) {
    location.href = '../login.html';
}