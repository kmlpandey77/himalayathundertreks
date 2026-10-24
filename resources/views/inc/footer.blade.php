<footer>
    <div class="overlay">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Contact us</h3>
                    <h4>{{ config('app.name') }}</h4>

                    <p>
                        <i class="fa fa-fw fa-map-marker"></i> {{ __l('global:address') }}<br>
                        <i class="fa fa-fw fa-mobile"></i> {{ __l('global:phone') }} <br>
                        <i class="fa fa-fw fa-envelope"></i> {{ __l('global:email') }} <br>
                    </p>

                    <hr>
                    <h4>Follow us on</h4>
                    <ul class="social-link">
                        @foreach ($socials as $social)
                        <li><a href="{{ $social['link'] }}" class="{{ $social['class'] }}" target="_blank"><i
                                    class="fab {{ $social['icon'] }}"></i></a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm">
                    <h3>Quick Links</h3>
                    <ul class="footer-link">
                        @if(count($footer_link) > 0)
                            @foreach ($footer_link as $link)
                                <li>
                                    <a href="{{ url($link['slug']) }}">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        @endif
                        <li>
                            <a href="{{ route('write-review') }}">Write Review</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm">
                    <h3>Trek Destination</h3>
                    <ul class="footer-link">
                        @foreach($footer_dests as $fdest)
                        <li><a href="{{ url($fdest['slug']) }}">{{ $fdest['title'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-sm-auto">
                    <div class="footer_affilated">
                        <h3>Affiliated with:</h3>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="Nepal Gov."><img class="img-fluid"
                                data-src="{{ asset('images/footer_img1.jpg') }}" alt="Nepal Gov." title="Nepal Gov."></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="NTB"><img class="img-fluid"
                                data-src="{{ asset('images/footer_img2.jpg') }}" alt="NTB" title="NTB"></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="TAAN"><img class="img-fluid"
                                data-src="{{ asset('images/footer_img3.jpg') }}" alt="TAAN" title="TAAN"></a>
                        <a href="#" data-toggle="tooltip" data-placement="top" title="NMA"><img class="img-fluid"
                                data-src="{{ asset('images/footer_img4.jpg') }}" alt="NMA" title="NMA"></a>
                    </div>
                    <div class="footer_cards mt-4">
                        <h3>We Accept Cards:</h3>
                        <a href="#" class="master"><img class="img-fluid" data-src="{{ asset('images/master.png') }}"
                                alt="Master Card" title="Master Card"></a>
                        <a href="#" class="visa"><img class="img-fluid" data-src="{{ asset('images/visa.png') }}"
                                alt="Visa Card" title="Visa Card"></a>
                        <a href="#" class="master"><img class="img-fluid" data-src="{{ asset('images/Ae.jpg') }}"
                                alt="AE" title="AE"></a>
                        <a href="#" class="master"><img class="img-fluid" data-src="{{ asset('images/sct.jpg') }}"
                                alt="SCT" title="SCT"></a>

                    </div>
                </div>
            </div>
        </div>

        <div class="copyright" id="_f_menu">
            <div class="container">
                <p>
                    <span>&copy; 1997 - {{ date('Y') }}, {{ config('app.name') }}</span>
                    <span> {{ __l('global:address') }}</span>
                    <span>All rights reserved.</span>
                </p>
            </div>
        </div>
    </div>
</footer>
<div id="backtotop" class="animated slideInUp">
    <i class="fa fa-angle-up"></i>
</div>