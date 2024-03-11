<!-- ========== App Menu ========== -->
<style type="text/css">
    .btn-logout {
        text-align: center;
        position: absolute;
        left: 50%;
        bottom: 20px;
        transform: translateX(-50%);
    }

    .btn-logout a.log-btn {
        color: #fff;
        background-color: #465a99;
        padding: 10px 100px;
        font-size: 15px;
        border-radius: 5px;
        display: flex;

    }
    .simplebar-content-wrapper {
        position: relative;
    }
</style>
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm-1.jpeg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="100%" width="100%" style="max-width: 120px;">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm-1.jpeg') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="100%" width="100%" style="max-width: 120px;">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div class="btn-logout">
                <a class="log-btn" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span key=""><i class="bx bx-power-off align-middle me-1"></i>  </span>Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-dashboard-2-line"></i> <span>@lang('translation.dashboards')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="dashboard" class="nav-link">@lang('translation.dashboards')</a>
                            </li> 
                            
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarBudget" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarBudget">
                        <i class="ri-money-dollar-circle-line"></i> <span>Budget</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarBudget">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
                                <a href="/projectlist" class="nav-link">Projects</a>
                            </li> 
                            <li class="nav-item">
                                <a href="/budget-project-list" class="nav-link">Project budgets</a>
                            </li> 
                            
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarExpense" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarExpense">
                        <i class="ri-money-dollar-circle-line"></i> <span>Expenses</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarExpense">
                        <ul class="nav nav-sm flex-column"> 
                            <li class="nav-item">
                                <a href="/servicelist" class="nav-link">Services list</a>
                            </li> 
                            <li class="nav-item">
                                <a href="/supplierlist" class="nav-link">Supplier list</a>
                            </li> 
                            <li class="nav-item">
                                <a href="/resourcelist" class="nav-link">Resources list</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="/executionresourcelist" class="nav-link">Execution list</a>
                            </li> -->
                            <li class="nav-item">
                                <a href="/executioncard" class="nav-link">Execution list</a>
                            </li>
                            <li class="nav-item">
                                <a href="/expenseslist" class="nav-link">Expenses list</a>
                            </li>
                            <li class="nav-item">
                                <a href="/execution-expense-summary-list" class="nav-link">Execution expenses summary list</a>
                            </li>
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarConfigure" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarConfigure">
                        <i class="ri-settings-line"></i> <span>Configuration</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarConfigure">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/companylist" class="nav-link">Company list</a>
                            </li> 

                            <li class="nav-item">
                                <a href="/userlist" class="nav-link">Users list</a>
                            </li> 
                            
                        </ul>
                    </div>
                </li> 
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccounting" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAccounting">
                        <i class="ri-calculator-line"></i> <span>Accounting</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccounting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/account-list" class="nav-link">Accounts</a>
                            </li> 

                            <li class="nav-item">
                                <a href="/cost-centre-list" class="nav-link">Cost centre</a>
                            </li> 
                            <li class="nav-item">
                                <a href="/expense-type-list" class="nav-link">Expense type</a>
                            </li> 
                            
                        </ul>
                    </div>
                </li> 
                
            </ul> 
        </div>
        <!-- Sidebar --> 
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
