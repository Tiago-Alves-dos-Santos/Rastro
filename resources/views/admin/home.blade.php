<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Rastro</title>
    <link rel="icon" href="{{ asset('img/logo-rastro.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap/css/bootstrap.min.css') }}">

    {{-- fullcalendar dependencias --}}
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/core/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/daygrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/timegrid/main.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/fullcalendar/list/main.css') }}">
    <script src="{{ asset('plugins/fullcalendar/core/main.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/core/locales-all.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/interaction/main.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/daygrid/main.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/timegrid/main.js') }}"></script>
    <script src="{{ asset('plugins/fullcalendar/list/main.js') }}"></script>
    {{-- fim fullcalendar dependencias --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/componentes/menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/usuario/home.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
@include('componentes.menu')

<div class="container">
    <div class="row">
        <div class="col-md-12 d-flex justify-content-center">
            <ul style="list-style: none;" class="sumario">
                <li id="agendada">Agendada</li>
                <li id="andamento">Em andamento</li>
                <li id="concluido">Concluida</li>
            </ul>
            <div style="clear: both"></div>
        </div>
    </div>
    <div id='calendar' style="margin-top: 20px">

    </div>
</div>

<script src="{{ asset('css/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('css/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('js/config.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script src="{{ asset('js/admin/home.js') }}"></script>
<script type="text/javascript">
    //habilitar fullcalendar
    document.addEventListener('DOMContentLoaded', function() {
        var initialLocaleCode = 'pt-br';
        var localeSelectorEl = document.getElementById('locale-selector');
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            defaultDate: "{{date('Y-m-d')}}",
            locale: initialLocaleCode,
            buttonIcons: true, // show the prev/next text
            weekNumbers: true,
            navLinks: true, // can click day/week names to navigate views
            editable: false,
            eventLimit: true, // allow "more" link when too many events
            events: [
                    @foreach($viagem_grupo as $viagem)
                    // strtotime($viagem->data_inicio) >= strtotime(date('Y-m-d'))
                    @if($viagem->status_viagem != "Cancelada")
                {
                    groupId: "{{$viagem->id_viagem}}",
                    title: "{{$viagem->origem}} - {{$viagem->destino}}",
                    start: '{{$viagem->data_inicio}}T'+'{{$viagem->horario_saida}}',
                    end: '{{$viagem->data_inicio}}T'+'{{$viagem->horario_saida}}',
                    fontColor: '#000',
                    url: '{{route('viagem.search',['id' => $viagem->id_viagem])}}',
                    @if($viagem->status_viagem == "Agendada")
                    color: '#546d2b'
                    @elseif($viagem->status_viagem == "Concluida")
                    color: '#d07f03'
                    @elseif($viagem->status_viagem == "Em andamento")
                    color: '#006abc'
                    @endif
                },
                    @endif
                    @endforeach

            ]
        });

        calendar.render();

    });
    //fim fullcaledar

</script>
</body>
</html>
