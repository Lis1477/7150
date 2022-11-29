@php
    if(!session('success')) {
        if(old('login_form') || old('reg_form') || old('remember_form') || session('logout'))  {
            $popup_style_par = "flex";

            if(old('login_form') || session('logout')) {
                $login_style_par = "block";
                $form_title = "Войти";
            } else {
                $login_style_par = "none";
            }

            if(old('reg_form')) {
                $reg_style_par = "block";
                $form_title = "Регистрация";
            } else {
                $reg_style_par = "none";
            }

            if (old('remember_form')) {
                $rem_style_par = "block";
                $form_title = "Восстановление пароля";
                $answer_style_par = "none";
                $answer_text = "";
            } else {
                $rem_style_par = "none";
                $answer_style_par = "none";
                $answer_text = "";
            }
        } else {
            $popup_style_par = "none";
            $login_style_par = "none";
            $answer_style_par = "none";
            $answer_text = "";
            $reg_style_par = "none";
            $form_title = "";
            $rem_style_par = "none";
        }
    } else {

        $popup_style_par = "flex";
        $form_title = session('success')['title'];
        $answer_style_par = "block";
        $answer_text = session('success')['text'];
        $login_style_par = "none";
        $reg_style_par = "none";
        $rem_style_par = "none";
    }

@endphp

<div class="popup-login js-popup-login" style="display: {{ $popup_style_par }};">
    
    <div class="popup-login_wrapper js-popup-wrapper"></div>

    <div class="popup-login_info-block">

        <div class="title js-form-title">{{ $form_title }}</div>

        <div class="close-button js-popup-close-button">✕</div>

        @include('auth.popups.login_form')
        @include('auth.popups.registration_form')
        @include('auth.popups.remember_form')
        @include('auth.popups.reg_answer')

    </div>


</div>
