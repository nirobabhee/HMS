<div class="sidebar {{ sidebarVariation()['selector'] }} {{ sidebarVariation()['sidebar'] }} {{ @sidebarVariation()['overlay'] }} {{ @sidebarVariation()['opacity'] }}"
    data-background="{{ getImage('assets/doctor/images/sidebar/2.jpg', '400x800') }}">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a href="{{ route('doctor.dashboard') }}" class="sidebar__main-logo"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] . '/logo.png') }}" alt="@lang('image')"></a>
            <a href="{{ route('doctor.dashboard') }}" class="sidebar__logo-shape"><img
                    src="{{ getImage(imagePath()['logoIcon']['path'] . '/favicon.png') }}" alt="@lang('image')"></a>
            <button type="button" class="navbar__expand"></button>
        </div>

        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item {{ menuActive('doctor.dashboard') }}">
                    <a href="{{ route('doctor.dashboard') }}" class="nav-link ">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title">@lang('Dashboard')</span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-stethoscope"></i>
                        <span class="menu-title">@lang('Doctors') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-notes-medical"></i>
                        <span class="menu-title">@lang('Schedule ') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-calendar-check"></i>
                        <span class="menu-title">@lang('Appointment') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-prescription"></i>
                        <span class="menu-title">@lang('Prescription') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-wheelchair"></i>
                        <span class="menu-title">@lang('Patient') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-tint"></i>
                        <span class="menu-title">@lang('Blood Bank') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.list')}}">
                    <a href="{{route('doctor.list')}}" class="nav-link"
                       data-default-url="{{ route('doctor.list') }}">
                        <i class="menu-icon las la-sms"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                    </a>
                </li>
                 <li class="sidebar-menu-item  {{menuActive('doctor.profile')}}">
                    <a href="{{route('doctor.profile')}}" class="nav-link"
                       data-default-url="{{ route('doctor.profile') }}">
                        <i class="menu-icon las la-user"></i>
                        <span class="menu-title">@lang('Profile') </span>
                    </a>
                </li>









                {{-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('doctor.ticket*',3)}}">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title">@lang('Support Ticket') </span>
                        @if (0 < $pending_ticket_count)
                            <span class="menu-badge pill bg--primary ml-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        @endif
                    </a>
                    <div class="sidebar-submenu {{menuActive('doctor.ticket*',2)}} ">
                        <ul>

                            <li class="sidebar-menu-item {{menuActive('doctor.ticket')}} ">
                                <a href="{{route('doctor.ticket')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('All Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('doctor.ticket.pending')}} ">
                                <a href="{{route('doctor.ticket.pending')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Pending Ticket')</span>
                                    @if ($pending_ticket_count)
                                        <span
                                            class="menu-badge pill bg--primary ml-auto">{{$pending_ticket_count}}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('doctor.ticket.closed')}} ">
                                <a href="{{route('doctor.ticket.closed')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Closed Ticket')</span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item {{menuActive('doctor.ticket.answered')}} ">
                                <a href="{{route('doctor.ticket.answered')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Answered Ticket')</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}


                {{-- <li class="sidebar-menu-item sidebar-dropdown">
                    <a href="javascript:void(0)" class="{{menuActive('doctor.report*',3)}}">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title">@lang('Report') </span>
                    </a>
                    <div class="sidebar-submenu {{menuActive('doctor.report*',2)}} ">
                        <ul>
                            <li class="sidebar-menu-item {{menuActive(['doctor.report.transaction','doctor.report.transaction.search'])}}">
                                <a href="{{route('doctor.report.transaction')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Transaction Log')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive(['doctor.report.login.history','doctor.report.login.ipHistory'])}}">
                                <a href="{{route('doctor.report.login.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Login History')</span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item {{menuActive('doctor.report.email.history')}}">
                                <a href="{{route('doctor.report.email.history')}}" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title">@lang('Email History')</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li> --}}






            </ul>
            <div class="text-center mb-3 text-uppercase">
                <span class="text--info">{{ __(systemDetails()['name']) }}</span>
                <span class="text--success">@lang('V'){{ systemDetails()['version'] }} </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->
