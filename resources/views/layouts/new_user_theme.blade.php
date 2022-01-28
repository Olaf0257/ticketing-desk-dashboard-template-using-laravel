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
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar user-navbar">
        <div>
          <a class="user-brand sidebar-brand" href="{{ route('home') }}">
            @if ($logo != null)
            <img src="/system_logo/{{ $logo }}" alt="{{ $app_name }}" class="logo">
            @else
            {{ $app_name }}
            @endif
          </a>
        </div>


        <ul class="navbar-nav navbar-right float-right ml-auto">
          <li><a class="nav-link   nav-link-lg nav-link-user" href="{{ route('articles.index') }}">
              <i class="fa fa-database mr-1" aria-hidden="true"></i>
              <div class="d-sm-none d-lg-inline-block">{{ __('Knowledge Base') }}</div>
            </a>
          </li>
          <li><a class="nav-link   nav-link-lg nav-link-user" href="{{ route('faq_list.index') }}">
              <i class="fas fa-question-circle mr-1"></i>
              <div class="d-sm-none d-lg-inline-block">{{ __('FAQs') }}</div>
            </a>
          </li>
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
              {{-- <div class="dropdown-title">Logged in 5 min ago</div> --}}

              <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> {{ __('Profile') }}
              </a>

              <div class="dropdown-divider"></div>
              <a class="dropdown-item has-icon" href=""><i class="far fa-question-circle"></i> {{ __('Help') }}</a>
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

      <!-- Main Content -->
      <div class="main-content main-sm-user main-user pl-md-5 pr-md-5">
        <section class="section">
          @yield('content')
        </section>
      </div>
      <footer class="main-footer public-footer">
        <div class="footer-left">
          {{ $footer_text }}
        </div>
        <div class="footer-right">
          <a href="{{ route('privacyPolicy') }}" class="pr-3 text-secondary">{{ __('Privacy Policy') }}</a><a
            href="{{ route('terms') }}" class="pr-3 text-secondary">{{ __('Terms of Use') }}</a><span>T.E 1.0.0</span>
        </div>
      </footer>
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/stisla.js') }}"></script>

  <!-- JS Libraies -->
  <script src="{{ asset('js/library.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ asset('js/script.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <!-- Page Specific JS File -->
</body>

</html>
