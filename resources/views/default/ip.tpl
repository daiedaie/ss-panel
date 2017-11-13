{include file='header.tpl'} 


<!--
<!DOCTYPE html>
<html>
 <head>
  <title>ip checker</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta http-equiv="Access-Control-Allow-Origin" content="*" /> 
  <link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon" />
  <link rel="stylesheet" type="text/css" href="assets/public/css/bootstrap.min.css" />
  <script src="assets/public/js/jquery-3.1.1.min.js"></script>

 </head>
 <body> 
-->


<h5 class="text-center">
  你的真实IP地址: 
  <p>
    [ {if isset($ip)} {$ip} {/if} ]
    <code class="bg-success text-success text-uppercase" id="country1"></code>
  </p>
</h5> 
<div class="container-fluid">
  <div class="col-sm-4 col-sm-offset-1 col-md-6 col-md-offset-3">
  <!-- <div class="col l12 offset-l3 m12 offset-m2 s6 offset-s1"> -->
    <table class="table table-hover table-striped">
<!--      <caption>clientip</caption> -->
      <thead> 
        <tr>
         <td>目标站点</td> 
         <td>使用IP</td> 
        </tr>
      </thead>
      <tbody>
        <tr> 
         <td scope="row"> 国内站点 </td> 
         <td><span class="text-primary"> {$ip} <code class="bg-success text-success text-uppercase" id="country2"></code></td> 
        </tr>
        <tr> 
         <td scope="row"> 国外站点 </td> 
         <td><span class="text-primary" id="ip3"></span><code class="bg-success text-success text-uppercase" id="country3"></code></td> 
        </tr>
      </tbody>
    </table>
 
    <div class="alert alert-warning alert-dismissible">
      <em> 说明： </em>
      <small>
        <ol>
          <li>如果没有全局代理或者VPN，<span class="text-primary">国内站点</span>右侧显示的IP就是您本机的IP。如果有，则显示的就是全局代理或者VPN的IP地址。</li>
          <li><span class="text-primary">国外站点</span>右侧IP就是您用来访问国外普通网站（没有被封的网站）的IP地址。</li>
        </ol>
      </small>
    </div>
  </div>
 
  <div class="col-sm-4 col-sm-offset-1 col-md-6 col-md-offset-3">
    <table class="table table-condensed">
<!--    <caption>connectivity</caption> -->
    <thead> 
      <tr>
       <td>访问网站</td> 
       <td>访问结果</td> 
      </tr>
    </thead>
    <tbody id="check-list">
{foreach $urls as $value}
      <tr> 
       <td><a href="{$value}">{$value@key}</a></td> 
       <td><i class="fa fa-spinner fa-pulse fa-lg fa-fw"></i><span class="sr-only">Loading...</span></td> 
      </tr>
{/foreach}
   </tbody>
   </table>
  </div>
</div>

<script src="assets/public/js/jquery-3.1.1.min.js"></script>
<script>
$(function() {
  $("#check-list > tr").each(function(i, e) {
    var s = this;
    jQuery.support.cors = true;
    var xhr = $.ajax({
      url: $(s).find("td").eq(0).find("a:first").attr("href") + "/favicon.ico",
      timeout: 5000,
      type: "GET",
      dataType: "JSONP",
      crossDomain: true})
      .fail(function(XMLHttpRequest, textStatus, errorThrown) {
        //alert(XMLHttpRequest.status + ":" + textStatus);
      })
      .done(function(){})
      .always(function(XMLHttpRequest, textStatus){
        switch(XMLHttpRequest.status) {
          case 0:
            $(s).find("td").eq(1).html("<span class='text-danger'>超时</span>");
            break;
          case 200:
          case 304:
          case 403:
            $(s).find("td").eq(1).html("<span class='text-success'>OK</span>");
            break;
          default:
            $(s).find("td").eq(1).html("<span class='text-danger'>无法访问(" + XMLHttpRequest.status + ")</span>");
            break;
        };
      })
    });
  })


</script>

<script type="text/javascript">
$(function() { 
  $.get(
    "https://ipinfo.io/json", 
    function(a) {
      $('#ip3').text(a.ip + " "); 
      $('#country3').text(a.country); 
    }
  );
  
{if isset($ip)}
  $.ajax(
    {
      url : 'http://ipinfo.io/{$ip}/json',
      type: "GET",
      dataType : "jsonp",
      data:{},
      timeout: 5000,
      success : function(j) {
        var t = "";
        if (j.bogon == true )
          v = "本地";
        else 
          v = j.country;
          
        $('#country1').text(v);$('#country2').text(v);
      }
    }
  );
{/if}
})
</script>

{include file='footer.tpl'}
