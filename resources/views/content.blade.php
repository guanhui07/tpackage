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

	<div class="adminPopup">
        <img src="/static/images/indextchide.png" class="adminPopup-close">
        <input id="l_admin_uid" name="" type="hidden" value="{{Admin::user()->id}}" >
        <div class="adminPopup-con">
            <h4>推瓜网提醒你</h4>
            <p>公共池资源请尽快领取，</br>八分钟后将重新分配！</p>
            <div class="adminPopup-conlist">
                <a>前往领取</a>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $.ajax({
                type: 'GET',
                url: '/admin/api/remindAdmin',
                dataType: 'json',
                success: function(reponse){
                    if (reponse.code === 200) {
                        $('.adminPopup').slideDown('slow');
                    }
                }
            })
        });
        $(function () {
            $('.adminPopup-close').click(function () {
                $('.adminPopup').slideUp('slow');
                setTimeout( function(){
                    $('.adminPopup').slideDown('slow');
                }, 10000);
            });
        });
    </script>
@endsection
