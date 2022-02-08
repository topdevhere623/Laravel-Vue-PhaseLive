@php $title = setting('title'); @endphp

<!doctype html>
<html lang="en-GB">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">

    @stack('styles')

    @yield('head')
</head>

<body>
    <nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ url('admin') }}">{{ $title }}</a>
        <form class="w-100 d-flex" action="{{ url('admin/' . $searchPath) }}" method="get">
            <input
                class="form-control form-control-dark w-100"
                name="search"
                value="{{ request('search') }}"
                type="text"
                placeholder="Search"
                aria-label="Search"
                {{ Request::is('admin/assets') ||
                    Request::is('admin/assets/*') ||
                    Request::is('admin/settings') ||
                    Request::is('admin/settings/*')
                    ? 'disabled' : '' }}
            >
            @if(Request::is('admin'))
                <select name="model" id="model" class="form-control form-control-dark form-control-lg col-md-4">
                    <option value="">Select Search Option</option>
                    <option value="pages">Page</option>
                    <option value="plans">Plan</option>
                    <option value="faqs">FAQ</option>
                    <option value="orders">Order</option>
                    <option value="genres">Genre</option>
                    <option value="releases">Release</option>
                    <option value="comments">Comment</option>
                    <option value="users">User</option>
                    <option value="roles">Roles</option>
                    <option value="permissions">Permission</option>
                </select>
            @endif
        </form>
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="/api/auth/logout">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link {{ Request::path() == 'admin' ? 'active' : null }}" href="{{ url('admin') }}">
                  <span data-feather="home"></span>
                  Dashboard
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/reports/unacknowledged') ? 'active' : null }}" href="{{ url('admin/reports/unacknowledged') }}">
                  <span data-feather="alert-triangle"></span>
                  @php $reportCount = App\Report::unacknowledged()->count() @endphp
                  @if($reportCount)
                    <strong>Reported Items ({{ $reportCount }})</strong>
                  @else
                    Reported Items
                  @endif
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/assets') || Request::is('admin/assets/*') ? 'active' : null }}" href="{{ url('admin/assets') }}">
                  <span data-feather="image"></span>
                  Assets
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/pages') || Request::is('admin/pages/*') ? 'active' : '' }}" href="{{ url('admin/pages') }}">
                  <span data-feather="paperclip"></span>
                  Pages
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/plans') || Request::is('admin/plans/*') ? 'active' : null }}" href="{{ url('admin/plans') }}">
                  <span data-feather="dollar-sign"></span>
                  Plans
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/faqs') || Request::is('admin/faqs/*') ? 'active' : null }}" href="{{ url('admin/faqs') }}">
                  <span data-feather="help-circle"></span>
                  FAQs
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/orders') || Request::is('admin/orders/*') ? 'active' : null }}" href="{{ url('admin/orders') }}">
                  <span data-feather="file-text"></span>
                  Orders
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/news') || Request::is('admin/news/*') ? 'active' : null }}" href="{{ url('admin/news') }}">
                  <span data-feather="send"></span>
                  News
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/genres') || Request::is('admin/genres/*') ? 'active' : null }}" href="{{ url('admin/genres') }}">
                  <span data-feather="speaker"></span>
                  Genres
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/releases') || Request::is('admin/releases/*') ? 'active' : null }}" href="{{ url('admin/releases') }}">
                  <span data-feather="disc"></span>
                  Releases
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/tracks') || Request::is('admin/tracks/*') ? 'active' : null }}" href="{{ url('admin/tracks') }}">
                  <span data-feather="music"></span>
                  Tracks
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/comments') || Request::is('admin/comments/*') ? 'active' : null }}" href="{{ url('admin/comments') }}">
                  <span data-feather="message-square"></span>
                  Comments
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/users') || Request::is('admin/users/*') ? 'active' : null }}" href="{{ url('admin/users') }}">
                  <span data-feather="users"></span>
                  Users
                </a>
              </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/roles') || Request::is('admin/roles/*') ? 'active' : null }}" href="{{ url('admin/roles') }}">
                  <span data-feather="user-check"></span>
                  Roles
                </a>
              </li>

              <li class="nav-item">
                  <a class="nav-link {{ Request::is('admin/permissions') || Request::is('admin/permissions/*') ? 'active' : null }}" href="{{ url('admin/permissions') }}">
                    <span data-feather="lock"></span>
                    Permissions
                  </a>
                </li>

              <li class="nav-item">
                <a class="nav-link {{ Request::is('admin/settings') || Request::is('admin/settings/*') ? 'active' : null }}" href="{{ url('admin/settings') }}">
                  <span data-feather="settings"></span>
                  Settings
                </a>
              </li>
            </ul>
          </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 pb-3 px-4" id="admin">
          @yield('content')
        </main>
      </div>
    </div>

    <!-- jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>

    <!-- Bootstrap -->
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    @stack('scripts')

    <!-- Icons -->
    <script src="//unpkg.com/feather-icons/dist/feather.min.js"></script>
    <script>
      feather.replace()
    </script>

    <!-- Uploads -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>

    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>

    <!-- Webfont -->
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ['Lato:400']
            }
        });
    </script>

    <script type="text/javascript">
      jQuery(function ($) {
        var $all = $('.select-all')
        var $genre = $('.page')

        $all.change(function () {
          if ($all.is(':checked')) {
            $genre.prop('checked', true)
          } else {
            $genre.prop('checked', false)
          }
        })
      })
    </script>
    <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script>
    <script src="/js/admin.js"></script>
    @yield('custom_js')
</body>
</html>
