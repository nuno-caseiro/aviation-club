@include('layouts.app')

<style>

    .nav-side-menu {
        overflow: auto;
        font-family: verdana;
        font-size: 12px;
        font-weight: 200;
        background-color: #2e353d;
        position: fixed;
        top: 0px;
        width: 300px;
        height: 100%;
        color: #e1ffff;
    }
    .nav-side-menu .brand {
        background-color: #23282e;
        line-height: 50px;
        display: block;
        text-align: center;
        font-size: 16px;
    }
    .nav-side-menu .toggle-btn {
        display: none;
    }
    .nav-side-menu ul,
    .nav-side-menu li {
        list-style: none;
        padding: 0px;
        margin: 0px;
        line-height: 35px;
        cursor: pointer;
        /*
          .collapsed{
             .arrow:before{
                       font-family: FontAwesome;
                       content: "\f053";
                       display: inline-block;
                       padding-left:10px;
                       padding-right: 10px;
                       vertical-align: middle;
                       float:right;
                  }
           }
      */
    }
    .nav-side-menu ul :not(collapsed) .arrow:before,
    .nav-side-menu li :not(collapsed) .arrow:before {
        font-family: FontAwesome;
        content: "\f078";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
        float: right;
    }
    .nav-side-menu ul .active,
    .nav-side-menu li .active {
        border-left: 3px solid #d19b3d;
        background-color: #4f5b69;
    }
    .nav-side-menu ul .sub-menu li.active,
    .nav-side-menu li .sub-menu li.active {
        color: #d19b3d;
    }
    .nav-side-menu ul .sub-menu li.active a,
    .nav-side-menu li .sub-menu li.active a {
        color: #d19b3d;
    }
    .nav-side-menu ul .sub-menu li,
    .nav-side-menu li .sub-menu li {
        background-color: #181c20;
        border: none;
        line-height: 28px;
        border-bottom: 1px solid #23282e;
        margin-left: 0px;
    }
    .nav-side-menu ul .sub-menu li:hover,
    .nav-side-menu li .sub-menu li:hover {
        background-color: #020203;
    }
    .nav-side-menu ul .sub-menu li:before,
    .nav-side-menu li .sub-menu li:before {
        font-family: FontAwesome;
        content: "\f105";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
    }
    .nav-side-menu li {
        padding-left: 0px;
        border-left: 3px solid #2e353d;
        border-bottom: 1px solid #23282e;
    }
    .nav-side-menu li a {
        text-decoration: none;
        color: #e1ffff;
    }
    .nav-side-menu li a i {
        padding-left: 10px;
        width: 20px;
        padding-right: 20px;
    }
    .nav-side-menu li:hover {
        border-left: 3px solid #d19b3d;
        background-color: #4f5b69;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        transition: all 1s ease;
    }
    @media (max-width: 767px) {
        .nav-side-menu {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }
        .nav-side-menu .toggle-btn {
            display: block;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 10 !important;
            padding: 3px;
            background-color: #ffffff;
            color: #000;
            width: 40px;
            text-align: center;
        }
        .brand {
            text-align: left !important;
            font-size: 22px;
            padding-left: 20px;
            line-height: 50px !important;
        }
    }
    @media (min-width: 767px) {
        .nav-side-menu .menu-list .menu-content {
            display: block;
        }
        #main {
            width:calc(100% - 300px);
            float: right;
        }
    }

    body {
        margin: 0px;
        padding: 0px;
    }

    .button {
        background-color: #2e353d;
        border: none;
        color: white;
        padding: 0px 40px;
        text-align: left;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 4px 2px;
        cursor: pointer;
    }

</style>

<div class="nav-side-menu">
    <div class="brand">Flight Club</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            {{--   <li>
                   <a href="#">
                       <i class="fa fa-dashboard fa-lg"></i> Dashboard
                   </a>
               </li>
           {{--   <li data-toggle="collapse" data-target="#products" class="collapsed active">
                     <a href="#"><i class="fa fa-gift fa-lg"></i> UI Elements <span class="arrow"></span></a>
                 </li>
            <ul class="sub-menu collapse" id="products">
                     <li class="active"><a href="#">CSS3 Animation</a></li>
                     <li><a href="#">General</a></li>
                     <li><a href="#">Buttons</a></li>
                     <li><a href="#">Tabs &amp; Accordions</a></li>
                     <li><a href="#">Typography</a></li>
                     <li><a href="#">FontAwesome</a></li>
                     <li><a href="#">Slider</a></li>
                     <li><a href="#">Panels</a></li>
                     <li><a href="#">Widgets</a></li>
                     <li><a href="#">Bootstrap Model</a></li>
                 </ul>
                 <li data-toggle="collapse" data-target="#service" class="collapsed">
                     <a href="#"><i class="fa fa-globe fa-lg"></i> Services <span class="arrow"></span></a>
                 </li>
                 <ul class="sub-menu collapse" id="service">
                     <li>New Service 1</li>
                     <li>New Service 2</li>
                     <li>New Service 3</li>
                 </ul>


               <li data-toggle="collapse" data-target="#new" class="collapsed">
                   <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
               </li>
               <ul class="sub-menu collapse" id="new">
                   <li>New New 1</li>
                   <li>New New 2</li>
                   <li>New New 3</li>
               </ul>  --}}
            <li >
                <a class="button" href="{{route("socios.index")}}">
                    {{--<i class="fa fa-user fa-lg"></i>--}} Socios
                </a>
            </li>
            <li>
                <a class="button" href="{{route("aeronaves.index")}}">
                     Aeronaves
                </a>
            </li>
            <li>
                <a class="button" href="{{route("movimentos.index")}}">
                     Movimentos
                </a>
            </li>

            <li>

                <a class="button" href="{{ url('/movimentos/estatisticas') }}">
                    Estatisticas
                </a>


            </li>

            <li>

                @can('socio_Direcao', App\User::class)
                    <a class="button" href="{{ url('/pendentes') }}">
                        Pendentes
                    </a>
                @endcan

            </li>


        </ul>
    </div>
</div>
<div class="container" id="main">
    <div class="row">
        <div class="col-md-12">
            <h1>FLIGHT CLUB</h1>
        </div>
    </div>
</div>

@auth
  {{-- <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="{{route("socios.index")}}">Socios</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route("aeronaves.index")}}">Aeronaves</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route("movimentos.index")}}">Movimentos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
        </li>
    </ul>
    --}}





@endauth





