{include file='header.tpl'}
<div class="section no-pad-bot" id="index-banner">
    <div class="container">
        <div class"row center">
          <h2 class="header col s12 m3 center blue-grey-text text-darken-4">{$config['slogan']}</h2>
        </div>
        <div class="row center">
            <h5 class="header col s12 light">科学上网   保护隐私</h5>
            {$homeIndexMsg}
        </div>
        {if $user->isLogin}
            <div class="row center">
                <a href="/user" id="download-button" class="btn-large waves-effect waves-light orange">进入用户中心</a>
            </div>
        {else}
        <div class="row center">
            <a href="/auth/register" id="download-button" class="btn-large waves-effect waves-light orange">立即注册</a>
        </div>
        {/if}
        <br><br>
    </div>
</div>


<div class="container">
    <div class="section">

        <!--   Icon Section   -->
        <div class="row">
            <div class="col s12 m3">
                <div class="icon-block">
                    
                    <h2 class="center light-blue-text"><a href="/downloads/apps/win/ShadowsocksR-4.7.0.1-win.7z"><i class="fa fa-windows"></i></a></h2>
                    <h5 class="center">Windows</h5>

                    <p class="light"> </p>
                </div>
            </div>

            <div class="col s12 m3">
                <div class="icon-block">
                    
                    <h2 class="center light-blue-text"><a href="https://raw.githubusercontent.com/teddysun/shadowsocks_install/master/shadowsocks.sh"><i class="fa fa-linux"></i></a></h2>
                    <h5 class="center">Linux</h5>

                    <p class="light"> </p>
                </div>
            </div><div class="col s12 m3">
                <div class="icon-block">
                    
                    <h2 class="center light-blue-text"><a href="https://play.google.com/store/apps/details?id=com.github.shadowsocks"><i class="fa fa-android"></i></a></h2>
                    <h5 class="center">Android</h5>

                    <p class="light"> </p>
                </div>
            </div><div class="col s12 m3">
                <div class="icon-block">
                    
                    <h2 class="center light-blue-text"><a href="https://itunes.apple.com/us/app/ssrconnect-proxy-utility/id1161221960?mt=8"><i class="fa fa-apple"></i></a></h2>
                    <h5 class="center">iOS</h5>

                    <p class="light"> </p>
                </div>
            </div>
        </div>

    </div>
    <br><br>

    <div class="section">

    </div>
</div>
{include file='footer.tpl'}
