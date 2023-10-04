<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{asset('../assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">{{ __('general_words.ministry_of_finance') }}</h4>
            <h4 class="logo-text" style="font-size: 13px;">{{ __('general_words.services_directorate') }}</h4>
        </div>
        <div class="toggle-icon me-auto"><i class='bx bx-arrow-to-right'></i>
        </div>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        
        <li>
            <a href="/dashboard">
                <div class="parent-icon"><i class='bx bx-home-circle'></i>
                </div>
                <div class="menu-title">{{ __('sidebar.dashboard') }}</div>
            </a>
        </li>
        
        <li>
            <a href="/documents">
                <div class="parent-icon"><i class='bx bx-book'></i>
                </div>
                <div class="menu-title">اسناد</div>
            </a>
        </li>
        <!-- @if(hasPermission(['setting_list']))
            <li>
                <a href="/settings">
                    <div class="parent-icon"><i class='bx bx-cog'></i>
                    </div>
                    <div class="menu-title">{{ __('sidebar.settings') }}</div>
                </a>
            </li>
        @endif -->
        @if(hasPermission(['setting_list']))
            <li>
            <a class="has-arrow" href="javascript:">
                <!-- <a href="/new_settings"> -->
                    <div class="parent-icon"><i class='bx bx-cog'></i>
                    </div>
                    <div class="menu-title">{{ __('sidebar.settings') }}</div>
                </a>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/item"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.items') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/employee"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.employee') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/directorate"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.directorate') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/category"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.category') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/unit_of_measure"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.unit_of_measure') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/donors"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.donor') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/venders"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.vendor') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/heiat"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.heiat_tashriah') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/hangars"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.hangar') }}
                            </a>
                        </li>
                    @endif
                </ul>
                <ul>
                    @if(hasPermission(['setting_list']))
                        <li><a href="/setting/motamed"><i class="fadeIn animated bx bx-cog"></i>{{ __('general_words.motamed') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
        @if(hasPermission(['user_list']) || hasPermission(['role_list']))
            <li>
                <a class="has-arrow" href="javascript:">
                    <div class="parent-icon"><i class="fadeIn animated bx bx-user"></i>
                    </div>
                    <div class="menu-title">{{ __('sidebar.user_management') }}</div>
                </a>
                <ul>
                    @if(hasPermission(['user_list']))
                        <li><a href="/user"><i class="fadeIn animated bx bx-user-voice"></i>{{ __('sidebar.users') }}
                            </a>
                        </li>
                    @endif
                    @if(hasPermission(['user_list']))
                        <li><a href="/role"><i class="fadeIn animated bx bx-key"></i>{{ __('sidebar.role') }}</a>
                        </li>
                    @endif
                </ul>
            </li>
        @endif
      
        @if(hasPermission(['reports_list'])) 
            <li>
                <a href="/reports/report">
                    <div class="parent-icon"><i class='bx bx-data'></i>
                    </div>
                    <div class="menu-title">{{ __('sidebar.reports') }}</div>
                </a>
            </li>
        @endif    
    </ul>

    <!--end navigation-->
</div>
<!--end sidebar wrapper -->
