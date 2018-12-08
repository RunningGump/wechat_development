<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wx106c10840592da71", "4084c6dc782833da91e6a090752d3055");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<script language="JavaScript" src="/static/jquery-3.3.1/jquery-3.3.1.js">
</script>
<html lang="en">
<head>
<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://apps.bdimg.com/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="https://apps.bdimg.com/libs/jquerymobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>

<body>
<center>
<div data-role="page" id="pageone">
  <div data-role="header">
  <h1>天气预报</h1>
  </div>
  <div data-role="content">
  <?php echo date("Y/m/d");
    ?>
  <p><span id="city"></span></p>
  <p><span id="district"></span></p>
  <p><span id="weather"></span></p>
  <p><span id="low"></span></p>
  <p><span id="high"></span></p>
  <p><span id="wind"></span></p>
  </div>

  <div data-role="footer">
  <h1>Stay hungry, Stay foolish!</h1>
  </div>
</div>
</center>
</body>
	
<!-- //flexSlider -->
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: true,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
    'getLocation',
	'openLocation',
    'scanQRCode'
    ]
  });
  
  // 微信访问本文件时，会自动执行wx.read()函数
  wx.ready(function () {
    // 在这里调用 API
  wx.getLocation({
		type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
		success: function (res) {
		var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
		var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
		var speed = res.speed; // 速度，以米/每秒计
		var accuracy = res.accuracy; // 位置精度
        //alert("latitude:" +latitude+ "longitude:" + longitude )
        //$json=file_get_contents("http://api.map.baidu.com/geocoder/v2/?location=".$latitude.",".$longitude."&output=json&pois=1&ak=F3T5CFoFLtMGHg1n6B10c1zB5uIGYPjI");
 		$.ajax({
                type: 'post',
                url: 'http://154.8.217.214/api/Ajax/read',
                data: {latitude: latitude, longitude: longitude},
                dataType: 'json',
                success: function (data) {
                  if (data.status == 0) {
                    alert(data.msg);
                  } else {
                    $("#city").text(data.city+data.district);
                    //$("#district").text(data.district);
                    $("#low").text("低温: " + data.min + "℃");
                    $("#high").text("高温: " + data.max + "℃");
                    $("#weather").text(data.weather);
                  }
                },
                error: function () { 
                  alert("程序异常");
                }
              });
       	}
  	});
  });

  function openLocation() {
      wx.ready(function () {
          wx.openLocation({
          latitude: latitude, // 纬度，浮点数，范围为90 ~ -90 longitude: longitude, // 经度，浮点数，范围为180 ~ -180。 name: '', // 位置名
          address: '', // 地址详情说明
          scale: 15, // 地图缩放级别,整形值,范围从1~28。默认为最⼤大 infoUrl: '' // 在查看位置界⾯面底部显示的超链接,可点击跳转
		  }); 
      });
}
  function scanQRCode(){
    wx.read(function() {
      wx.scanQRCode({
        needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
        scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
        success: function (res) {
        var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
        }
     });
   });
 }
</script>
</html>
