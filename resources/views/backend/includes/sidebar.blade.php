<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ access()->user()->picture }}" class="img-circle" alt="User Image" />
            </div><!--pull-left-->
            <div class="pull-left info">
                <p>{{ access()->user()->first_name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('strings.backend.general.status.online') }}</a>
            </div><!--pull-left-->
        </div><!--user-panel-->

        <!-- search form (Optional) -->
        {{--{{ Form::open(['route' => 'admin.search.index', 'method' => 'get', 'class' => 'sidebar-form']) }}--}}
        {{--<div class="input-group">--}}
            {{--{{ Form::text('q', Request::get('q'), ['class' => 'form-control', 'required' => 'required', 'placeholder' => trans('strings.backend.general.search_placeholder')]) }}--}}
            {{--<span class="input-group-btn">--}}
                {{--<button type='submit' id='search-btn' class="btn btn-flat">--}}
                    {{--<i class="fa fa-search"></i>--}}
                {{--</button>--}}
            {{--</span><!--input-group-btn-->--}}
        {{--</div><!--input-group-->--}}
        {{--{{ Form::close() }}--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            {{--<li class="header">{{ trans('menus.backend.sidebar.general') }}</li>--}}

            <li class="{{ active_class(Active::checkUriPattern('admin/dashboard*')) }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.backend.sidebar.dashboard') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/medicine-type*')) }}">
                <a href="{{ route('admin.medicine-type.index') }}">
                    <i class="fa fa-plus-square"></i>
                    <span>{{ trans('menus.backend.sidebar.medicine-type') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/therapeutic-class-group*')) }}">
                <a href="{{ route('admin.therapeutic-class-group.index') }}">
                    <i class="fa fa-object-group"></i>
                    <span>{{ trans('menus.backend.sidebar.therapeutic-class-group') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/therapeutic-class')) }}">
                <a href="{{ route('admin.therapeutic-class.index') }}">
                    <i class="fa fa-object-ungroup"></i>
                    <span>{{ trans('menus.backend.sidebar.therapeutic-class') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/indications*')) }}">
                <a href="{{ route('admin.indications.index') }}">
                    <i class="fa fa-hospital-o"></i>
                    <span>{{ trans('menus.backend.sidebar.indications') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/generic-name*')) }}">
                <a href="{{ route('admin.generic-name.index') }}">
                    <i class="fa fa-h-square"></i>
                    <span>{{ trans('menus.backend.sidebar.generic-name') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/pharmaceutical-companies*')) }}">
                <a href="{{ route('admin.pharmaceutical-companies.index') }}">
                    <i class="fa fa-industry"></i>
                    <span>{{ trans('menus.backend.sidebar.pharmaceutical-companies') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/lab-test*')) }}">
                <a href="{{ route('admin.lab-test.index') }}">
                    <i class="fa fa-heartbeat"></i>
                    <span>{{ trans('menus.backend.sidebar.lab-test') }}</span>
                </a>
            </li>
            <li class="{{ active_class(Active::checkUriPattern('admin/lab-test-category*')) }}">
                <a href="{{ route('admin.lab-test-category.index') }}">
                    <i class="fa fa-anchor"></i>
                    <span>Lab Test Category</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/medicine*')) }}">
                <a href="{{ route('admin.medicine.index') }}">
                    <i class="fa fa-medkit"></i>
                    <span>{{ trans('menus.backend.sidebar.medicine') }}</span>
                </a>
            </li>

            <li class="{{ active_class(Active::checkUriPattern('admin/allergies*')) }}">
                <a href="{{ route('admin.allergies.index') }}">
                    <i class="fa fa-snowflake-o"></i>
                    <span>{{ trans('menus.backend.sidebar.allergies') }}</span>
                </a>
            </li>

            {{--<li class="header">{{ trans('menus.backend.sidebar.system') }}</li>--}}

            @role(1)
            <li class="{{ active_class(Active::checkUriPattern('admin/access/*')) }} treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>{{ trans('menus.backend.access.title') }}</span>

                    @if ($pending_approval > 0)
                        <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                    @else
                        <i class="fa fa-angle-left pull-right"></i>
                    @endif
                </a>

                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/access/*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/access/*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/access/user*')) }}">
                        <a href="{{ route('admin.access.user.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.users.management') }}</span>

                            @if ($pending_approval > 0)
                                <span class="label label-danger pull-right">{{ $pending_approval }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/access/role*')) }}">
                        <a href="{{ route('admin.access.role.index') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('labels.backend.access.roles.management') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endauth

            <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer*')) }} treeview">
                <a href="#">
                    <i class="fa fa-list"></i>
                    <span>{{ trans('menus.backend.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'menu-open') }}" style="display: none; {{ active_class(Active::checkUriPattern('admin/log-viewer*'), 'display: block;') }}">
                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer')) }}">
                        <a href="{{ route('log-viewer::dashboard') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.dashboard') }}</span>
                        </a>
                    </li>

                    <li class="{{ active_class(Active::checkUriPattern('admin/log-viewer/logs')) }}">
                        <a href="{{ route('log-viewer::logs.list') }}">
                            <i class="fa fa-circle-o"></i>
                            <span>{{ trans('menus.backend.log-viewer.logs') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section><!-- /.sidebar -->
</aside>