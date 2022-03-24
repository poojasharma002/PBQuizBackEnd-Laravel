@include('layout.header')

@include('layout.navbar')

@include('layout.aside')

@yield('content')

@stack('scripts')

@include('layout.footer')

