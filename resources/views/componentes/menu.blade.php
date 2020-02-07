<script src="https://kit.fontawesome.com/100dc002c3.js"></script>
<nav class="navbar navbar-expand-lg navbar-dark bg-verde" id="menu-nav">
    <div class="container">
        <a class="navbar-brand" href="">Rastro</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#conteudoNavbarSuportado" aria-controls="conteudoNavbarSuportado" aria-expanded="false" aria-label="Alterna navegação">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="conteudoNavbarSuportado">
            <ul class="navbar-nav ml-auto">
                @if (session()->get('tipo_usuario', "usuario") == "administrador")
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('admin.home') }}">Inicio <span class="sr-only">(página atual)</span></a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('user.home') }}">Inicio <span class="sr-only">(página atual)</span></a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('agendar') }}">Agendar Viagem</a>
                </li>
                {{-- cadastros --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cadastrar
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('create.cliente') }}">Cliente</a></li>
                        @if (session()->get('tipo_usuario', "usuario") == "administrador")
                        <li><a class="dropdown-item" href="{{ route('create.veiculo') }}">Veiculo</a></li>
                        <li><a class="dropdown-item" href="{{ route('create.usuario') }}">Usuário</a></li>
                        <li><a class="dropdown-item" href="{{ route('create.fornecedor') }}">Fornecedor</a></li>

                        {{--criar classe dropdown-submenu--}}
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Motorista</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('create.motorista') }}">Cadastrar</a></li>
                                <li><a class="dropdown-item" href="{{route('create.despesa')}}">Despesas</a></li>
                            </ul>
                        </li>
                            @endif
                    </ul>
                </li>

                {{-- consultar --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Consultar
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
{{--                        session()->get('tipo_usuario', "usuario") == "administrador"--}}
                        @if (true)
                            <a class="dropdown-item" href="{{ route('read.viagem') }}">Viagem</a>
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ route('read.cliente') }}">Cliente</a>
                        @if (session()->get('tipo_usuario', "usuario") == "administrador")
                            <a class="dropdown-item" href="{{ route('read.veiculo') }}">Veiculo</a>
                            <a class="dropdown-item" href="{{ route('read.usuario') }}">Usuário</a>
                            <a class="dropdown-item" href="{{ route('read.motorista') }}">Motorista</a>
                            <a class="dropdown-item" href="{{ route('read.fornecedor') }}">Fornecedor</a>
                        @endif
                    </div>
                </li>
                {{-- consultar --}}
{{--                @if (session()->get('tipo_usuario', "usuario") == "administrador")--}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tarefas
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('user.rotina.viagem')}}">Rotina de Viagens</a>
                        </div>
                    </li>
{{--                @endif--}}
                <li class="nav-item">
                    <a id="logout" class="nav-link" href="{{ route('user.logout') }}" data-toggle="tooltip" data-placement="bottom" title="Sair!"><i class="fas fa-sign-out-alt fa-lg"></i></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
