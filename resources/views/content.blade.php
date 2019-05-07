@extends('admin::index')

@section('content')
    <section class="content-header">
        <h1>
            {{ $header ?: trans('admin.title') }}
            <small>{{ $description ?: trans('admin.description') }}</small>
        </h1>

        <!-- breadcrumb start -->
        @if ($breadcrumb)
        <ol class="breadcrumb" style="margin-right: 30px;">
            <li><a href="{{ admin_url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            @foreach($breadcrumb as $item)
                @if($loop->last)
                    <li class="active">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </li>
                @else
                <li>
                    <a href="{{ admin_url(array_get($item, 'url')) }}">
                        @if (array_has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    </a>
                </li>
              @endif
            @endforeach
        </ol>
        @endif
        <!-- breadcrumb end -->

    </section>

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        {!! $content !!}

    </section>

    {{--  --}}
    <input id="l_admin_uid" name="" type="hidden" value="{{Admin::user()->id}}" >
    <input id="l_admin_type" name="" type="hidden" value="{{Admin::user()->type}}" >
    {{-- 资源池弹框 --}}
    <div class="adminPopup" id="adminPopup">
        <img src="/houtai/images/adminPopup_close.png" class="adminPopup-close" id="adminPopup-close">
        <div class="adminPopup-con">
            <img src="/houtai/images/adminPopup_bg.png" class="adminPopup_bg">
            <h4>推瓜网提醒你</h4>
            <p>公共池资源请尽快领取，</br>八分钟后将重新分配！</p>
            <div class="adminPopup-conlist">
                <a id="adminPopup-type">前往领取</a>
            </div>
        </div>
    </div>
    {{-- 新求购弹框 --}}
    <div class="adminPopup" id="adminPopup-buy">
        <img src="/houtai/images/adminPopup_close.png" class="adminPopup-close" id="adminPopup-buy-close">
        <div class="adminPopup-con">
            <img src="/houtai/images/adminPopup_bg.png" class="adminPopup_bg">
            <h4>推瓜网提醒你</h4>
            <p>店铺新求购~请尽快回复</p>
            <div class="adminPopup-conlist">
                <a id="adminPopup-buy-type">跳转回复</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var popupTime;
        var popupBuyTime;
        $(document).ready(function(){
            var adminPopupId = localStorage.getItem('adminPopupId');
            var l_admin_type = $('#l_admin_type').val();
            if (!adminPopupId) {
                popupShow();
                window.clearInterval(popupTime);
                popupTime = setInterval(function(){
                    popupShow();
                }, 30000);
            }
            // 新求购访问
            // if (window.location.href.indexOf('/admin/enterprise/requirement/qqbuy') == -1) {
            //     if (l_admin_type == 1) {
            //         successBuy();
            //         window.clearInterval(popupBuyTime);
            //         popupBuyTime = setInterval(function(){
            //             successBuy();
            //         }, 40000);
            //     }
            // }
        });
        function popupShow(){
        /*
            var uid = $('#l_admin_uid').val();
            $.ajax({
                type: 'GET',
                url: 'http://adminapi.tuigua.com/index/index?uid=' + uid, // '/api2/get1',
                //url: 'http://121.43.162.244/index/index?uid=' + uid, //'/admin/api/remindAdmin',
                dataType: 'json',
                success: function(reponse){
                    if (reponse.code === 200) {
                        if (reponse.data != -1) {
                            $('#adminPopup').slideDown('slow');
                            $('#adminPopup-type').attr('href', '/admin/enterprise/resoucepool?type='+ reponse.data +'&no_get=1');
                        }
                    } else {
                        window.clearInterval(popupTime);
                        localStorage.setItem('adminPopupId', reponse.data.uid);
                    }
                }
            });
         */
        }
        // 求购弹窗
        function successBuy () {
            var adminId = $('#l_admin_uid').val();
            $.ajax({
                type: 'GET',
                url: '/trade_new/index.php?r=index/index&adminId=' + adminId,
                dataType: "json",
                success: function(reponse){
                    console.log('reponse=', reponse);
                    if (reponse.code === 200) {
                        if (reponse.data != -1) {
                            $('#adminPopup-buy').slideDown('slow');
                            $('#adminPopup-buy-type').attr('href', '/admin/enterprise/requirement/qqbuy?shop_buy_id='+ reponse.data.shop_buy_id);
                        }
                    } else {
                        window.clearInterval(popupBuyTime);
                    }
                }
            });
        }
        $(function () {
            $('#adminPopup-close').click(function () {
                $('#adminPopup').slideUp('slow');
                window.clearInterval(popupTime);
                popupTime = setInterval(function(){
                    popupShow();
                }, 30000);
            });
            $('#adminPopup-buy-close').click(function () {
                $('#adminPopup-buy').slideUp('slow');
                window.clearInterval(popupBuyTime);
                popupBuyTime = setInterval(function(){
                    successBuy();
                }, 40000);
            });
        });
    </script>
@endsection
