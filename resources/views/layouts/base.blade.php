<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

@php
    if(!isset($title)) {
        $title = "Интернет-магазин 7150.by";
    }
    if(!isset($keywords)) {
        $keywords = "";
    }
    if(!isset($description)) {
        $description = "";
    }
@endphp

    <title>{{ $title }}</title>
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="description" content="{{ $description }}">

	@php($version = date('Ymd'))

    <link rel="stylesheet" href="{{ asset('css/styles.css?v='.$version) }}">
    <link rel="stylesheet" href="{{ asset('css/adaptive.css?v='.$version) }}">

@section('css')
@show

</head>
<body>

@include('includes.header')

@yield('content')

@include('includes.footer')

@include('auth.popups.popup_login')
@include('popups.note')
@include('popups.one_click_order_form')
@include('popups.feedback')
@include('popups.want_cheaper')


<script type="text/javascript" src="{{ asset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"> </script>

<script type="text/javascript" src="{{ asset('js/menu_mobile.js?v='.$version) }}"></script>
<script type="text/javascript" src="{{ asset('js/category_button_handler.js?v='.$version) }}"></script>
<script type="text/javascript" src="{{ asset('js/number_format.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/in_cart.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/user_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/search.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/feedback_popup.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/captcha_validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/favorite_items.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/one_click_order.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/cat_link_handler.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/header_phones.js') }}"></script>
<script>
    console.log('маска для телефона');
    $(document).ready(function() {
        $(".phone-input").mask("+375 (99) 999-99-99");
    });
</script>

@section('scripts')
@show

</body>
</html>