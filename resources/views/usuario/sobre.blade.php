<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro-Informação</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/componentes/menu.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@include('componentes.menu')


<div class="container">
    <div class="row mt-4">
        <div class="col-md-12 d-flex justify-content-center">
            <h1>Sobre Chronos Three</h1>
        </div>
    </div>

    <div class="row mt-4 mb-4" style="border-bottom: 0.5px solid gray">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{asset('img/leinylson.jpg')}}" class="img-fluid img-sobre"/>
                </div>
                <div class="col-md-">
                    <ul style="list-style: none">
                        <li>Nome: Leinylson Fontinele Pereira</li>
                        <li>Função: Anonima Função</li>
                        <li><a href="https://www.linkedin.com/in/leinylson/" target="_blank"><i class="fab fa-facebook fa-lg"></i></a> || <a href="https://www.instagram.com/leinylson/" target="_blank" style="color: rgb(236, 61, 66)"><i class="fab fa-instagram fa-lg"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{asset('img/bruno.jpg')}}" class="img-fluid img-sobre"/>
                </div>
                <div class="col-md-">
                    <ul style="list-style: none">
                        <li>Nome: Bruno do Santos</li>
                        <li>Função: Analista de Sistemas</li>
                        <li><a href="https://www.facebook.com/profile.php?id=100007038483799&ref=br_rs" target="_blank"><i class="fab fa-facebook fa-lg"></i></a> || <a target="_blank" href="https://www.instagram.com/brunosantosoficial_1996/" style="color: rgb(236, 61, 66)"><i class="fab fa-instagram fa-lg"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4 mb-4" style="">

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{asset('img/tiago.jpg')}}" class="img-fluid img-sobre" />
                </div>
                <div class="col-md-">
                    <ul style="list-style: none">
                        <li>Nome: Tiago Alves</li>
                        <li>Função: Desenvolvedor Full-Stack</li>
                        <li><a target="_blank" href="https://www.facebook.com/tiagooliveiraaso?ref=bookmarks"><i class="fab fa-facebook fa-lg"></i></a> || <a target="_blank" href="https://www.instagram.com/tiagooliveiraaso/" style="color: rgb(236, 61, 66)"><i class="fab fa-instagram fa-lg"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{asset('img/chronos.jpg')}}" class="img-fluid img-sobre"/>
                </div>
                <div class="col-md-">
                    <ul style="list-style: none">
                        <li>Chronos Three Tecnologia</li>
                        <li>1-Desenvolvimento de sistemas empresariais</li>
                        <li>2-Criação de sites personalizados</li>
                        <li>3-Consultoria em tecnologia da informação.</li>
                        <li>4-Apoio a gestão de empresas</li>
                        <li><a href="https://www.facebook.com/chronosthree/" target="_blank"><i class="fab fa-facebook fa-lg"></i></a> || <a href="https://www.instagram.com/chronosthree_tecnologia/" target="_blank" style="color: rgb(236, 61, 66)"><i class="fab fa-instagram fa-lg"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@include('componentes.rodape')
{{--fim do modal cancelamneto de viagem--}}
@php
    session()->forget('msg');
@endphp
<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>

</body>
</html>
