<header>
    <div class="topbar d-flex align-items-center">
       <nav class="navbar navbar-expand">
          <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
          </div>
          <div class="flex-grow-1">
            <div id="clock" style="font-size:18px; width:150px; text-align:left"></div>
           <script>
            setInterval(showClock, 1000);
               function showClock() {
               const date = new Date();
               document.getElementById("clock").innerHTML = date.toLocaleTimeString();
               }
       
           </script>
          </div>

<div class="nav-item dropdown">
                <a class="dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ __('general_words.'.App::getLocale()) }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach (Config::get('languages') as $lang => $language)
                        @if ($lang != App::getLocale())
                            <a class="dropdown-item" href="{{ route('lang.switch', $lang) }}"> {{ __('general_words.'.$lang)}}</a>
                        @endif
                    @endforeach
                </div>
            </div>

            <div id="setDate" class="nav-item dropdown">
                <a class="dropdown-toggle dropdown-toggle-split" 
                        data-bs-toggle="dropdown" aria-expanded="false" 
                        href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" 
                        aria-haspopup="true" aria-expanded="false">
                    {{ __('general_words.date') }}
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a href="#" class="dropdown-item" onClick="setDefoultDate('hijri')">{{ __('general_words.hijri_qamari') }}</a>
                  <a href="#" class="dropdown-item" onClick="setDefoultDate('jalali')">{{ __('general_words.hijri_shamsi') }}</a>
                  <a href="#" class="dropdown-item" onClick="setDefoultDate('gregorian')">{{ __('general_words.miladi') }}</a>
                </div>
            </div>


         <div class="top-menu ms-auto">
            <ul class="navbar-nav align-items-center">
               <li class="nav-item mobile-search-icon">
                  <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                  </a>
               </li>
               <li class="nav-item dropdown dropdown-large">
                  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>
                  <i class='bx bx-bell'></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                     <a href="javascript:;">
                        <div class="msg-header">
                           <p class="msg-header-title">Notifications</p>
                           <p class="msg-header-clear ms-auto">Marks all as read</p>
                        </div>
                     </a>
                     <div class="header-notifications-list">
                        <a class="dropdown-item" href="javascript:;">
                           <div class="d-flex align-items-center">
                              <div class="notify bg-light-warning text-warning"><i class='bx bx-door-open'></i>
                              </div>
                              <div class="flex-grow-1">
                                 <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
                                    ago</span>
                                 </h6>
                                 <p class="msg-info">45% less alerts last 4 weeks</p>
                              </div>
                           </div>
                        </a>
                     </div>
                     <a href="javascript:;">
                        <div class="text-center msg-footer">View All Notifications</div>
                     </a>
                  </div>
               </li>
               <li class="nav-item dropdown dropdown-large">
                  <div class="dropdown-menu dropdown-menu-end">
                     <div class="header-message-list">

                  </div>
               </li>
            </ul>
         </div>

          <div class="user-box dropdown">
             <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" style="border:none;" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{asset('../assets/images/avatars/avatar-2.png')}}" class="user-img" alt="user avatar">
                <div class="user-info ps-3">
                   <p class="user-name mb-0">{{ Auth::user()?Auth::user()->name:null }}</p>
                   <!-- <p class="designattion mb-0">{{ Auth::user()?Auth::user()->email:null }}</p> -->
                </div>
             </a>
             <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out-circle"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <!-- <a class="dropdown-item" onclick="openPasswordResetModel">
                        <i class="bx bx-log-out-circle"></i>change password
                    </a> -->
                </li>
             
             </ul>
          </div>
       </nav>
    </div>
</header>
