<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use \think\Route;
Route::get('private','demo/test/test');
//测试
Route::get('demo','demo/demo/index');

//首页
// Route::any('/','index/index/index');
Route::get('info','admin/index/info');
Route::post('ine','index/index/ine');
Route::post('role/create','index/role/create');
Route::get('role/getRole/:id','index/role/getRole');
Route::get('role/update/:id','index/role/update');
Route::get('role/delete/:id','index/role/delete');
Route::get('role/auth/:id','index/role/delete');

//用户操作
Route::get('user/index','index/user/index');
Route::post('user/insert','index/user/insert');//用户注册
Route::post('user/login','index/user/login');//用户登录
Route::post('user/loginquick','index/user/loginquick');//快速退出
Route::post('user/loginout','index/user/loginout');//用户退出
Route::get('user/emailtokin','index/user/emailtokin');
Route::post('user/resetRequest','index/user/resetRequest');
Route::get('user/getuser/:id','index/user/getuser');
Route::get('user/getall/:id','index/user/getall');
Route::post('user/getallid','index/user/getallid');
Route::post('user/deluser','index/user/deluser');
Route::post('user/get','index/user/get');

//用户详情
Route::post('userinfo/get','index/userinfo/get');//获取用户详情
Route::post('userinfo/update','index/userinfo/update');//更新用户详情
Route::post('userinfo/upload','index/userinfo/upload');
Route::post('userinfo/phone','index/userinfo/phone');//判断手机号是否可用于注册
Route::post('userinfo/isnull','index/userinfo/isnull');//发布技能时判断资料是否完善
Route::post('userinfo/randpic','index/userinfo/randpic');//根据性别随机头像

// 钱包
Route::post('wallet/insert','index/wallet/insert');//充值
Route::post('wallet/get','index/wallet/get');//获取用户钱包数据
Route::post('wallet/update','index/wallet/update');//更新钱包数据
Route::post('wallet/pay','index/wallet/pay');//确认付款（判断支付密码是否正确）
Route::post('wallet/isexists','index/wallet/isexists');//判断支付密码是否存在

//钱包详情
Route::post('walletdetails/get','index/walletdetails/get');
Route::post('walletdetails/getall','index/walletdetails/getall');//获取全部收益
Route::post('walletdetails/getallpay','index/walletdetails/getallpay');//获取全部支出



//银行账户管理
Route::post('accounts/insert','index/accounts/insert');//添加提现账户
Route::post('accounts/get','index/accounts/get');//获取关联账号
Route::post('accounts/update','index/accounts/update');//获取关联账号
Route::post('accounts/find','index/accounts/find');//获取单条数据

//意见反馈
Route::post('feedback','index/feedback/add');//添加意见返回

//个人简历
Route::post('resume/cateinsert','index/resume/cateinsert');//分类添加(项目经验、工作经验、学历信息)
Route::post('resume/update','index/resume/update');
Route::post('resume/get','index/resume/get');//获取资料完善度
Route::post('resume/gettotal','index/resume/gettotal');//获取简历所有资料信息
Route::post('resume/isnull','index/resume/isnull');//判断字段是否为空

//学历信息
Route::post('degree/isnull','index/degree/isnull');//判断学历信息是否存在
Route::post('degree/get','index/degree/get');//获取学历信息
Route::post('degree/update','index/degree/update');//更新学历信息
Route::post('degree/find','index/degree/find');//获取单条数据

//项目经验
Route::post('proexperience/get','index/proexperience/get');//获取项目经验
Route::post('proexperience/isexists','index/proexperience/isExists');//判断项目经验是否存在
Route::post('proexperience/update','index/proexperience/update');//更新项目经验
Route::post('proexperience/find','index/proexperience/find');//根据id查询项目经验
Route::post('proexperience/insert','index/proexperience/insert');//添加项目经验

//工作经验
Route::post('experience/get','index/experience/get');//获取项目经验
Route::post('experience/update','index/experience/update');//更新项目经验
Route::post('experience/find','index/experience/find');//查询单条项目经验
Route::post('experience/insert','index/experience/insert');//添加项目经验
Route::post('experience/isnull','index/experience/isnull');//判断是否添加工作经验

//发布技能
Route::post('skill/insert','index/skill/insert');//发布技能
Route::post('skill/update','index/skill/update');//更新技能
Route::post('skill/get','index/skill/get');//获取发布的技能
Route::post('skill/delete','index/skill/delete');
Route::post('skill/find','index/skill/find');//获取单条技能数据
Route::post('skill/getdata','index/skill/getdata');//获取单条技能数据
Route::post('skill/multifind','index/skill/multifind');//多条件搜索(或)
Route::post('skill/unionfind','index/skill/unionfind');//多条件搜索(与);
Route::post('category/get','index/category/get');//获取类别选项
Route::post('category/insert','index/category/insert');//添加类别选项

//获取城市信息
Route::post('city/get','index/city/get');//获取城市数据

//微聘雇人
Route::post('employ/insert','index/employ/insert');//发布需求
Route::post('employ/get','index/employ/get');//获取任务需求
Route::post('employ/getselect','index/employ/getselect');//获取任务标签
Route::post('employ/inserttype','index/employ/inserttype');//添加任务标签
Route::post('employ/find','index/employ/find');//添加任务标签
Route::post('employ/update','index/employ/update');//修改任务信息
Route::post('employ/delete','index/employ/delete');//删除任务信息
Route::post('employ/getdata','index/employ/getdata');//按条件查询任务
Route::post('employ/getnows','index/employ/getnow');//获取进行中任务
Route::post('employ/getends','index/employ/getend');//获取已完成任务
Route::post('employ/findtitle','index/employ/findtitle');//添加竞品优势时获取任务名称
Route::post('employ/multifind','index/employ/multifind');//多条件查询(或)
Route::post('employ/unionfind','index/employ/unionfind');//多条件查询(与)

//获取分类
Route::post('cate/get','index/cate/get');
Route::post('cate/find','index/cate/find');

//搜索历史
Route::post('searchhistory/insert','index/search/insert');//添加搜索历史
Route::post('searchhistory/delete','index/search/delete');//删除搜索历史
Route::post('searchhistory/get','index/search/get');//获取搜索历史

//竞品优势
Route::post('advantage/insert','index/advantage/insert');//添加竞品优势

//申请者清单
Route::post('applicantlist/insert','index/applicantlist/insert');//新增申请者
Route::post('applicantlist/getemploy','index/applicantlist/getemploy');//获取投递过的任务
Route::post('applicantlist/update','index/applicantlist/update');//更新
Route::post('applicantlist/get','index/applicantlist/get');//获取列表
Route::post('applicantlist/support','index/applicantlist/support');//点赞

//订单
Route::post('orders/insert','index/orders/insert');//生成订单
Route::post('orders/get','index/orders/get');
Route::post('orders/getdata','index/orders/getdata');//获取全部订单
Route::post('orders/getnow','index/orders/getnow');//获取进行中订单
Route::post('orders/getend','index/orders/getend');//获取已完成订单
Route::post('orders/getclosed','index/orders/getclosed');//获取已关闭订单
Route::post('orders/update','index/orders/update');//更新订单信息
Route::post('orders/getstatus','index/orders/getstatus');//获取角色状态
Route::post('orders/find','index/orders/find');//获取单条数据
Route::post('orders/getpay','index/orders/getpay');//获取支付详情
Route::post('orders/willpay','index/orders/willpay');//获取待结金额
Route::post('orders/mytask','index/orders/mytask');//获取我的任务详情
Route::post('orders/maintask','index/orders/maintask');//获取发布的任务详情
Route::post('applicantlist/message','index/orders/message');//招聘消息（雇主身份）
Route::post('orders/messageworker','index/orders/messageworker');//招聘消息(能人身份)

//判断是否有新消息
Route::post('orders/ismessage','index/orders/ismessage');

//订单评论
Route::post('ordercomment/insert','index/ordercomment/insert');//添加评论、回复数据
Route::post('ordercomment/get','index/ordercomment/get');//获取评论、回复数据
Route::post('ordercomment/support','index/ordercomment/support');//点赞
Route::post('ordercomment/issupport','index/ordercomment/issupport');//判断用户是否点赞

//合同
Route::post('agreement/update','index/agreement/update');//更新合同信息
Route::post('agreement/insert','index/agreement/insert');//添加合同任务节点
Route::post('agreement/get','index/agreement/get');//获取合同中默认信息
Route::post('agreement/find','index/agreement/find');//读取合同数据
Route::post('agreement/delnode','index/agreement/delnode');//删除任务节点

//证书技能
Route::post('certificate/insert','index/certificate/insert');//发布证书技能
Route::post('certificate/update','index/certificate/update');//更新证书技能
Route::post('certificate/get','index/certificate/get');//获取证书技能
Route::post('certificate/find','index/certificate/find');//根据id查询证书技能

//身份认证
Route::post('authentication/insert','index/Authentication/insert');//添加认证信息
Route::post('authentication/get','index/Authentication/get');//查询数据

//收藏
Route::post('collection/insert','index/collection/insert');//添加收藏
Route::post('collection/get','index/collection/get');
Route::post('collection/delete','index/collection/delete');//删除收藏
Route::post('collection/getdata','index/collection/getdate');//查询用户收藏技能

//发现
Route::post('task_type/get','index/task_type/get');

//来访记录
Route::post('visitor/insert','index/visitor/insert');//新增来访记录
Route::post('visitor/get','index/visitor/get');//获取来访记录
Route::post('visitor/delete','index/visitor/delete');//删除来访记录
Route::post('visitor/isscan','index/visitor/isscan');

Route::get('json','index/json/index');

// 分词
Route::post('employ/participle','index/index/participle');


//后台管理
Route::get('admin','admin/index/index');
Route::get('test','admin/index/test');

Route::any('admin/login','admin/login/login');
Route::get('admin/logout','admin/logout/logout');

Route::get('admin/userlist','admin/userlist/index');
Route::get('admin/sealuser','admin/userlist/sealuser');
Route::get('admin/userlist/userinfo','admin/userlist/userinfo');
Route::any('admin/userlist/insert','admin/userlist/insert');//用户添加
Route::any('admin/userlist/import','admin/userlist/import');//导入用户页面

Route::post('admin/userupdate','admin/userlist/userupdate');

Route::any('admin/password','admin/password/update');

Route::get('admin/admin','admin/admin/index');
Route::post('admin/adminadd','admin/admin/add');
Route::get('admin/admindel','admin/admin/del');
Route::post('admin/adminupdates','admin/admin/updates');
Route::get('admin/adminuppage','admin/admin/uppage');

Route::get('admin/role','admin/role/index');
Route::post('admin/roleadd','admin/role/add');
Route::get('admin/roledel','admin/role/del');
Route::get('admin/detail','admin/detail/index');
Route::post('admin/upload','admin/detail/upload');
Route::get('admin/role/permissions','admin/role/permissions');

Route::get('admin/menu','admin/menu/index');
Route::get('admin/menu/delete','admin/menu/delete');
Route::post('admin/menu/edit','admin/menu/edit');
Route::post('admin/menu/insert','admin/menu/insert');
Route::post('admin/menu/pathedit','admin/menu/pathedit');
Route::get('admin/menu/set','admin/menu/set');
Route::post('admin/menu/setedit','admin/menu/setedit');

Route::post('admin/role/permissionwrite','admin/role/permissionwrite');

Route::get('admin/userinfo/index','admin/userinfo/index');
Route::get('admin/userinfo/edit','admin/userinfo/edit');
Route::post('admin/userinfo/update','admin/userinfo/updata');

Route::get('admin/orders/index','admin/orders/index');
Route::get('admin/orders/edit','admin/orders/edit');
Route::post('admin/orders/update','admin/orders/update');
Route::get('admin/orders/create','admin/orders/create');
Route::post('admin/orders/insert','admin/orders/insert');
Route::get('admin/error/index','admin/OrderError/index');

Route::get('admin/authentication/index','admin/authentication/index');
Route::get('admin/authentication/edit','admin/authentication/edit');
Route::post('admin/authentication/update','admin/authentication/update');
Route::get('admin/company/index','admin/company/index');

Route::get('admin/employ/index','admin/employ/index');
Route::get('admin/employ/edit','admin/employ/edit');
Route::post('admin/employ/update','admin/employ/update');
Route::get('admin/employ/del','admin/employ/del');

Route::get('admin/skill/index','admin/skill/index');
Route::any('admin/skill/edit','admin/skill/edit');
Route::get('admin/skill/delete','admin/skill/delete');

Route::get('admin/category_review/list','admin/category/category_review');
Route::get('admin/category_review/submit','admin/category/submit');
Route::get('admin/category/list','admin/category/category');
Route::get('admin/category/edit','admin/category/edit');
Route::post('admin/category/update','admin/category/update');
Route::post('admin/category/check','admin/category/check');

Route::get('admin/task_typereview/list','admin/task/task_typereview');
Route::get('admin/task_typereview/submit','admin/task/submit');
Route::get('admin/task_type/list','admin/task/task_type');
Route::get('admin/task_type/edit','admin/task/edit');
Route::post('admin/task_type/update','admin/task/update');
Route::get('admin/task_type/delete','admin/task/delete');
Route::post('admin/task_type/insert','admin/task/insert');
Route::get('admin/cate/index','admin/cate/index');
Route::post('admin/cate/insert','admin/cate/insert');
Route::post('admin/cate/edit','admin/cate/edit');
Route::post('admin/cate/doedit','admin/cate/doedit');
Route::post('admin/cate/delete','admin/cate/delete');

Route::get('admin/wallet_details/index','admin/wallet_details/index');
Route::get('admin/WalletDetails/accounts','admin/WalletDetails/accounts');
Route::get('admin/WalletDetails/pay','admin/WalletDetails/pay');

Route::get('admin/accounts/index','admin/accounts/index');
Route::get('admin/accounts/edit','admin/accounts/edit');
Route::post('admin/accounts/update','admin/accounts/update');


Route::get('admin/category/getsa','admin/category/get');
Route::get('admin/category/i','admin/category/i');
Route::get('admin/employ/getsa','index/employ/getData');

//合同管理
Route::get('admin/agreement/index','admin/agreement/index');//列表
Route::any('admin/agreement/details','admin/agreement/details');//详情

//二维码
Route::get('index/qrcodes/index','index/qrcodes/index');
Route::get('index/qrcodes/qrcodes','index/qrcodes/qrcodes');
Route::post('index/qrcodes/renovateCode','index/qrcodes/renovateCode');
Route::post('index/qrcodes/codetime','index/qrcodes/codetime');
Route::get('index/qrcodes/isCode','index/qrcodes/isCode');

/*微聘网页端*/
Route::get('/','home/index/index');//首页

//网页二维码登陆
Route::get('login/index','home/login/index');
Route::get('login/qrcodes','home/login/qrcodes');
Route::get('login/renovateCode','home/login/renovateCode');
Route::post('login/codetime','home/login/codetime');
Route::get('login/isCode/:time','home/login/isCode');
Route::post('login/enter','home/login/enter');
Route::post('login/SmsCode','home/login/SmsCode');

//注册
Route::post('login/register','home/login/register');

// 下载
Route::get('download/index','home/download/index');

//用户
Route::post('pcuser/insert','home/user/insert');//用户添加
Route::post('makemoney/insert','home/makemoney/insert');//微聘赚钱
Route::post('pcemploy/insert','home/employ/insert');//微聘雇人
Route::get('pcemploy/index','home/employ/index');//立即雇人
Route::get('pcskill/index','home/skill/index');//立即赚钱
Route::post('pcorder/insert','home/order/insert');//订单
Route::post('pcwallet/get','home/wallet/get');//钱包

Route::get('employ/index','home/employ/index');//任务需求
Route::post('pcemploy/insert','home/employ/insert');//任务插入
Route::get('employ/condition','home/employ/condition');//立即雇人搜索