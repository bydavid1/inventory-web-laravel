<footer class="footer footer-light @if(isset($configData['footerType'])){{$configData['footerClass']}}@endif">
  <p class="clearfix mb-0">
    <span class="float-left d-inline-block">2020 &copy; e-box</span>
    <span class="float-right d-sm-inline-block d-none">Desarrollado por
      <a class="text-uppercase" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Byron Jimenez</a>
    </span>
    @if($configData['isScrollTop'] === true)
    <button class="btn btn-primary btn-icon scroll-top" type="button">
      <i class="bx bx-up-arrow-alt"></i>
    </button>
    @endif
  </p>
</footer>
