<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('admin/dashboard')}}">
        <div class="sidebar-brand-text mx-3">PınarPen</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if(Request::segment(2)=='dashboard') active @endif">
        <a class="nav-link" href="{{url('admin/dashboard')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Anasayfa</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - Pages Collapse Menu -->

    <!-- Accounting  -->
    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='accounting' and Request::segment(3)=='customers') in @else collapsed @endif"
           href="#" data-toggle="collapse" data-target="#customersCollapse"
           aria-expanded="true" aria-controls="customersCollapse">
            <i class="fas fa-user-friends"></i>
            <span>Müşteriler</span>
        </a>
        <div id="customersCollapse"
             class="collapse @if(Request::segment(2)=='accounting' and Request::segment(3)=='customers') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Müşteri İşlemleri:</h6>
                <a class="collapse-item  @if(Request::segment(2)=='accounting' and Request::segment(3)=='customers' and !Request::segment(4))active @endif"
                   href="{{url("/admin/accounting/customers/")}}">Tüm Müşteriler</a>
                <a class="collapse-item @if(Request::segment(2)=='accounting' and  Request::segment(3)=='customers' and Request::segment(4)=='create') active @endif"
                   href="{{url("/admin/accounting/customers/create")}}">Müşteri Ekle</a>
            </div>
        </div>

    </li>

    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='accounting' and Request::segment(3)=='projects') in @else collapsed @endif"
           href="#" data-toggle="collapse" data-target="#projectsCollapse"
           aria-expanded="true" aria-controls="projectsCollapse">
            <i class="fas fa-tasks"></i>
            <span>Projeler</span>
        </a>
        <div id="projectsCollapse"
             class="collapse @if(Request::segment(2)=='accounting' and Request::segment(3)=='projects') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Proje İşlemleri:</h6>
                <a class="collapse-item  @if(Request::segment(2)=='accounting' and Request::segment(3)=='projects' and !Request::segment(4))active @endif"
                   href="{{url("/admin/accounting/projects/")}}">Tüm Projeler</a>
                <a class="collapse-item @if(Request::segment(2)=='accounting' and  Request::segment(3)=='projects' and Request::segment(4)=='create') active @endif"
                   href="{{url("/admin/accounting/projects/create")}}">Proje Ekle</a>
            </div>
        </div>

    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='suppliers') in @else collapsed @endif" href="#"
           data-toggle="collapse" data-target="#suppliersCollapse"
           aria-expanded="true" aria-controls="portfoliosCollapse">
            <i class="fas fa-box-open"></i>
            <span>Tedarikçiler</span>
        </a>
        <div id="suppliersCollapse" class="collapse @if(Request::segment(2)=='accounting' and Request::segment(3)=='suppliers') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tedarikçi İşlemleri:</h6>
                <a class="collapse-item  @if(Request::segment(2)=='accounting' and Request::segment(3)=='suppliers' and !Request::segment(4)) active @endif"
                   href="{{url("/admin/accounting/suppliers/")}}">Tüm Tedarikçiler</a>
                <a class="collapse-item @if(Request::segment(2)=='accounting' and Request::segment(3)=='suppliers' and Request::segment(4) == "create") active @endif"
                   href="{{url("/admin/accounting/suppliers/create")}}">Tedarikçi Ekle</a>
            </div>
        </div>

    </li>
    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='debts') in @else collapsed @endif" href="#"
           data-toggle="collapse" data-target="#debtsCollapse"
           aria-expanded="true" aria-controls="portfoliosCollapse">
            <i class="fas fa-pen"></i>
            <span>Tedarikçi Borçları</span>
        </a>
        <div id="debtsCollapse" class="collapse @if(Request::segment(2)=='accounting' and Request::segment(3)=='debts') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tedarikçi Borç İşlemleri:</h6>
                <a class="collapse-item  @if(Request::segment(2)=='accounting' and Request::segment(3)=='debts' and !Request::segment(4)) active @endif"
                   href="{{url("/admin/accounting/debts/")}}">Tüm Tedarikçi Borçları</a>
                <a class="collapse-item @if(Request::segment(2)=='accounting' and Request::segment(3)=='debts' and Request::segment(4) == "create") active @endif"
                   href="{{url("/admin/accounting/debts/create")}}">Tedarikçi Borcu Ekle</a>
            </div>
        </div>

    </li>
    <li class="nav-item @if(Request::segment(2)=='accounting' and Request::segment(3)=='customer-payments') active @endif">
        <a class="nav-link " href="{{url("/admin/accounting/customer-payments/")}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Müşteri Borç Ödemeleri</span></a>
    </li>

    <li class="nav-item @if(Request::segment(2)=='accounting' and Request::segment(3)=='debt-payments') active @endif">
        <a class="nav-link " href="{{url("/admin/accounting/debt-payments/")}}">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Tedarikçi Borç Ödemeleri</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='suppliers') in @else collapsed @endif" href="#"
           data-toggle="collapse" data-target="#expenditureCollapse"
           aria-expanded="true" aria-controls="expenditureCollapse">
            <i class="fas fa-pen"></i>
            <span>Harici Giderler</span>
        </a>
        <div id="expenditureCollapse" class="collapse @if(Request::segment(2)=='accounting' and Request::segment(3)=='expenditures') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Harici Gider İşlemleri:</h6>
                <a class="collapse-item  @if(Request::segment(2)=='accounting' and Request::segment(3)=='expenditures' and !Request::segment(4)) active @endif"
                   href="{{url("/admin/accounting/expenditures/")}}">Tüm Harici Giderler</a>
                <a class="collapse-item @if(Request::segment(2)=='accounting' and Request::segment(3)=='expenditures' and Request::segment(4) == "create") active @endif"
                   href="{{url("/admin/accounting/expenditures/create")}}">Harici Gider Ekle</a>
            </div>
        </div>

    </li>

    <!-- PınarPen  -->

    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='portfolios') in @else collapsed @endif" href="#"
           data-toggle="collapse" data-target="#portfoliosCollapse"
           aria-expanded="true" aria-controls="portfoliosCollapse">
            <i class="far fa-newspaper"></i>
            <span>Porfolyolar</span>
        </a>
        <div id="portfoliosCollapse" class="collapse @if(Request::segment(2)=='portfolios') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Portfolyo İşlemleri:</h6>
                <a class="collapse-item @if(Request::segment(2)=='portfolios' and !Request::segment(3)) active @endif"
                   href="{{url("/admin/portfolios/")}}">Tüm Portfolyolar</a>
                <a class="collapse-item @if(Request::segment(2)=='portfolios' and Request::segment(3)=='create') active @endif"
                   href="{{url("/admin/portfolios/create")}}">Portfolyo Oluştur</a>
            </div>
        </div>

    </li>

    <li class="nav-item">
        <a class="nav-link @if(Request::segment(2)=='services') in @else collapsed @endif" href="#"
           data-toggle="collapse" data-target="#servicesCollapse"
           aria-expanded="true" aria-controls="servicesCollapse">
            <i class="fas fa-car-side"></i>
            <span>Hizmetler</span>
        </a>
        <div id="servicesCollapse" class="collapse @if(Request::segment(2)=='services') show @endif"
             aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Hizmet İşlemleri:</h6>
                <a class="collapse-item @if(Request::segment(2)=='services' and !Request::segment(3)) active @endif"
                   href="{{url("/admin/services")}}">Tüm Hizmetler</a>
                <a class="collapse-item @if(Request::segment(2)=='services' and Request::segment(3)=='create') active @endif"
                   href="{{url("/admin/services/create")}}">Hizmet Ekle</a>
            </div>
        </div>

    </li>

</ul>
