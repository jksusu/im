layui.use('layim', function (layim) {
    //基础配置
    layim.config({

        init: {
            url: url + 'Api/Index/init'
            , type: 'post'
            , data: {
                uid: uid
            }
        } //获取主面板列表信息，下文会做进一步介绍

        //上传图片接口（返回的数据格式见下文）
        , uploadImage: {
            url: '' //接口地址
            , type: 'post' //默认post
        }

        //上传文件接口（返回的数据格式见下文）
        , uploadFile: {
            url: '' //接口地址
            , type: 'post' //默认post
        }

        //扩展“更多”的自定义列表，下文会做进一步介绍（如果无需扩展，剔除该项即可）
        , moreList: [{
            alias: 'find'
            , title: '发现'
            , iconUnicode: '&#xe628;' //图标字体的unicode，可不填
            , iconClass: '' //图标字体的class类名
        }]

        //扩展工具栏，下文会做进一步介绍（如果无需扩展，剔除该项即可）
        , tool: [{
            alias: 'code' //工具别名
            , title: '代码' //工具名称
            , iconUnicode: '&#xe64e;' //工具图标，参考图标文档，可不填
            , iconClass: '' //图标字体的class类名
        }]
    });
});