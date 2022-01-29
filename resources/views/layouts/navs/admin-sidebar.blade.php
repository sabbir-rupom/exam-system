<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Menu</li>

                <li>
                    <a href="{{ url('/dashboard') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-dashboards">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-format-list-text"></i>
                        <span key="t-manage-catalogue">Manage Catalogue</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('entity.category.index') }}" key="t-entity-category">
                            <i class="bx bx-chevron-right"></i>
                            Category
                        </a></li>
                        <li><a href="{{ route('entity.category-class.index') }}" key="t-entity-class">
                            <i class="bx bx-chevron-right"></i>
                            Class
                        </a></li>
                        <li><a href="{{ route('entity.subject.index') }}" key="t-entity-subject">
                            <i class="bx bx-chevron-right"></i>
                            Subject
                        </a></li>
                    </ul>
                </li>
                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-cog"></i>
                        <span key="t-system-settings">Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" key="t-email-settings">
                            <i class="bx bx-chevron-right"></i>
                            Email
                        </a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
