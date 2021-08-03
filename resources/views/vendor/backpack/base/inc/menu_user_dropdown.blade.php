<li class="nav-item dropdown pr-4">
  <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
    @if (backpack_user()->profile)
      <img class="img-avatar" src="{{ asset('backpack_auth()->user()->profile') }}" alt="{{ backpack_auth()->user()->name }}">
    @else
      <img class="img-avatar" src="{{ backpack_avatar_url(backpack_auth()->user()) }}" alt="{{ backpack_auth()->user()->name }}">
      
    @endif
  </a>
  <div class="dropdown-menu {{ config('backpack.base.html_direction') == 'rtl' ? 'dropdown-menu-left' : 'dropdown-menu-right' }} mr-4 pb-1 pt-1">
    <a class="dropdown-item" href="{{ route('backpack.account.info') }}"><i class="la la-user"></i> {{ trans('backpack::base.my_account') }}</a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ backpack_url('logout') }}"><i class="la la-lock"></i> {{ trans('backpack::base.logout') }}</a>
  </div>
</li>
<span class="custom-padding d-none d-md-block">{{ backpack_user()->name }}</span>