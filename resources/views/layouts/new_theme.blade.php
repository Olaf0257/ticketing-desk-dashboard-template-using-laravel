<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $app_name }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fontawesome.css') }}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('css/selectric.css') }}">
  <link rel="stylesheet" href="{{ asset('css/summernote-bs.min.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/components.css') }}">
  <link href="{{ asset('css/vue-select.css') }}" rel="stylesheet">
  <script src="{{ asset('js/vue.min.js') }}"></script>
  <script src="{{ asset('js/vue-select.js') }}"></script>
  <script src="{{ asset('js/axios.min.js') }}"></script>
  <link href="{{ asset('css/v-quill-editor.css') }}" rel="stylesheet">
  <script src="{{ asset('js/v-quill-editor.min.js') }}"></script>



</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <i class="fas fa-globe-asia mr-1"></i>
              <div class="d-sm-none d-lg-inline-block">{{ __('Language.') }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              @foreach ($languages as $language)
              <a href="/lang/{{ $language->code }}" class="dropdown-item has-icon">
                {{ $language->language }}
              </a>
              @endforeach
            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <i class="fa fa-user-circle mr-1"></i>
              <div class="d-sm-none d-lg-inline-block">{{ __('Hi') }}, {{ Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

              <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{ __('Profile') }}
              </a>

              <div class="dropdown-divider"></div>
              <a class="dropdown-item has-icon" target="_blank"
                href="https://ticketing.expert/basic_docs/1.1.0/user-doc.html"><i class="far fa-question-circle"></i>
                {{ __('Help') }}</a>
              <div class="dropdown-divider"></div>
              <a href{{ route('logout') }} class="dropdown-item has-icon text-danger pointer" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="">
              @if ($logo != null)
              <img src="/system_logo/{{ $logo }}" alt="{{ $app_name }}" class="logo">
              @else
              {{ $app_name }}
              @endif
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="">{{ $app_name_short }}</a>
          </div>
          <ul class="sidebar-menu">

            @if (Auth::check() && Auth::user()->role != 'null')
            @if (Auth::check() && Auth::user()->role != 'user')
            <li class="menu-header">{{ __('Dashboard') }}</li>
            <li class="{{ Request::is('dashboard') ||  Request::is('/')? 'active' : '' }}"> <a class="nav-link"
                href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>{{ __('Dashboard') }}</span></a>
            </li>
            @endif

            <li class="menu-header">{{ __('Ticket Area') }}</li>

            @if (Auth::check() && Auth::user()->role != 'admin')
            <li class="{{ Request::is('ticket/create') ? 'active' : '' }}"> <a class="nav-link"
                href="{{ route('ticket.create') }}"><i
                  class="fas fa-pen-square"></i><span>{{ __('Open Ticket') }}</span></a>
            </li>
            @endif

            @if (Auth::check() && Auth::user()->role != 'user')
            @if (($imap_enables->value) == '1')
            <li class="{{ Request::is('imap_ticket*') || Request::is('imap_status_tickets*')  ? 'active' : '' }}"><a
                class="nav-link" href="{{ route('imap_ticket.index') }}"><i
                  class="fas fa-envelope"></i><span>{{ __('Email Tickets') }}</span></a></li>
            @endif
            @endif

            <li
              class="{{ (Request::is('ticket*') &&  !Request::is('ticket/create') &&  !Request::is('ticket_status*')) || Request::is('status_tickets*') ? 'active' : '' }}">
              <a class="nav-link" href="{{ route('ticket.index') }}"><i
                  class="fas fa-ticket-alt"></i><span>{{ __('Web Tickets') }}</span></a></li>

            @if (Auth::check() && Auth::user()->role == 'staff')
            <li
              class="dropdown {{ (Request::is('my_ticket') || Request::is('assigned_to_me') || Request::is('email_assigned_to_me')) ? 'active' : '' }}">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i>
                <span>{{ __('My tickets') }}</span></a>
              <ul class="dropdown-menu">
                <li class="{{ Request::is('my_ticket') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('my_ticket') }}">{{ __('Tickets Opened By Me') }}</a></li>
                <li class="{{ Request::is('assigned_to_me') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('ticket_assigned_me') }}">{{ __('Assigned Web Tickets') }}</a></li>
                <li class="{{ Request::is('email_assigned_to_me') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('email_ticket_assigned_me') }}">{{ __('Assigned Email Tickets') }}</a></li>
              </ul>
            </li>
            @endif

            @endif

            @if (Auth::check() && Auth::user()->role != 'user')
            <li class="menu-header">{{ __('Ticket General') }}</li>

            @if (Auth::check() && Auth::user()->role == 'staff')
            <li class="{{ Request::is('user*') ? 'active' : '' }}"> <a class="nav-link"
                href="{{ route('user.index') }}"><i class="fas fa-users"></i><span>{{ __('Users') }}</span></a>
            </li>
            @endif

            @if ((Auth::check() && Auth::user()->role == 'admin') || $statusPermission == true)
            <li class="{{ Request::is('ticket_status*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('ticket_status.index') }}"><i
                  class="fas fa-fill"></i><span>{{ __('Ticket statuses') }}</span></a></li>
            @endif
            @if ((Auth::check() && Auth::user()->role == 'admin') || $departmentPermission == true)
            <li class="{{ Request::is('department*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('department.index') }}"><i
                  class="fas fa-building"></i><span>{{ __('Departments') }}</span></a></li>
            @endif

            <li class="{{ Request::is('email_template*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('email_template.index') }}"><i
                  class="fas fa-envelope-open-text"></i><span>{{ __('Email Templates') }}</span></a></li>

            @if ((Auth::check() && Auth::user()->role == 'admin') || $tagsPermission == true)
            <li class="{{ Request::is('tags*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('tags.index') }}"><i class="fas fa-tags"></i><span>{{ __('Tags') }}</span></a></li>
            @endif
            <li class="{{ Request::is('canned_responses*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('canned_responses.index') }}"><i
                  class="fas fa-reply"></i><span>{{ __('Canned Responses') }}</span></a></li>

            <li class="{{ Request::is('error_log*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('error_log.index') }}"><i
                  class="fas fa-exclamation-triangle"></i><span>{{ __('Error Logs') }}</span></a></li>
            @endif

            @if (Auth::check() && Auth::user()->role == 'admin')
            <li class="menu-header">{{ __('Admin Area') }}</li>
            <li class="{{ Request::is('staff*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('staff.index') }}"><i class="fas fa-users"></i><span>{{ __('Staffs') }}</span></a></li>
            <li class="{{ Request::is('settings*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('settings.index') }}"><i class="fas fa-cogs"></i><span>{{ __('Settings') }}</span></a>
            </li>
            <li class="{{ Request::is('language*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('language.index') }}"><i class="fas fa-language"
                  aria-hidden="true"></i><span>{{ __('Add language') }}</span></a></li>

            <li class="{{ Request::is('permissions') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('permissions') }}"><i
                  class="fas fa-user-lock"></i><span>{{ __('Permissions') }}</span></a></li>
            @endif

            @if (Auth::check() && Auth::user()->role != 'user')
            @if ((Auth::check() && Auth::user()->role == 'admin') || $kbPermission == true)
            <li class="menu-header">{{ __('Knowledge Base') }}</li>
            <li class="{{ Request::is('faq_category*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('faq_category.index') }}"><i
                  class="fas fa-stream"></i><span>{{ __('FAQ Categories') }}</span></a></li>

            <li class="{{ Request::is('faq*') && !Request::is('faq_category*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('faq.index') }}"><i class="fas fa-question-circle"></i><span>{{ __('FAQs') }}</span></a>
            </li>

            <li class="{{ Request::is('kb_category*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('kb_category.index') }}"><i
                  class="fas fa-info-circle"></i><span>{{ __('KB Categories') }}</span></a></li>

            <li class="{{ Request::is('kb_article*') ? 'active' : '' }}"><a class="nav-link"
                href="{{ route('kb_article.index') }}"><i class="fa fa-database"
                  aria-hidden="true"></i><span>{{ __('KB Articles') }}</span></a></li>
            @endif
            @endif
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @yield('content')
        </section>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          {{ $footer_text }}
        </div>
        <div class="footer-right">
          <a href="{{ route('privacyPolicy') }}" class="pr-3 text-secondary">{{ __('Privacy Policy') }}</a><a
            href="{{ route('terms') }}" class="pr-3 text-secondary">{{ __('Terms of Use') }}</a><span>T.E 1.1.0</span>
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('js/library.js') }}"></script>
  <script src="{{ asset('js/chart.min.js') }}"></script>
  <script src="{{ asset('js/chart.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <!-- Page Specific JS File -->
</body>

</html>
