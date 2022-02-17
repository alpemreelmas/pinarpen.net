@extends('layouts.master')
@section('body-class', 'contact')
@section('content')
<div class="container content-container">
    <div class="content-title">
        <h2>iletişim</h2>
    </div>
    <div class="content contact-content">
        <div class="content-left">
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                <a href="tel:+905303414159">+90 530 341 41 59</a>
            </div>
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                <a href="mailto:pinarpenihat@hotmail.com">pinarpenihat@hotmail.com</a>
            </div>
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                <a href="https://www.instagram.com/pinarpentekirdag/" target="_blank">@pinarpentekirdag</a>
            </div>
            <div class="contact-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                <a href="https://www.facebook.com/profile.php?id=100059427332939" target="_blank">Pınar Pen</a>
            </div>
        </div>
        <div class="content-right">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2167.5133608069286!2d27.48629028337834!3d40.96690770248667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14b461ca15e63ea7%3A0x1928e4ce6de96f35!2sP%C4%B1nar%20Pen!5e0!3m2!1str!2str!4v1640547586344!5m2!1str!2str" width="600" height="450" style="border:0; border-radius: 0.5rem" allowfullscreen="" loading="lazy" class="google-maps"></iframe>
        </div>
    </div>
</div>
@endsection