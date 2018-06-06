<nav class="top-bar">
      <div class="container">
        <div class="row">
        <div class="col-sm-4 hidden-xs">
            <span class="nav-text">
                <i class="fa fa-phone" aria-hidden="true"></i>  +987 500 120
                <i class="fa fa-envelope" aria-hidden="true"></i> {{$author}}</span>
            </div>
        <div class="col-sm-2 text-center">
            <a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-twitter" aria-hidden="true"></i></a>
            <a href="#" class="social"><i class="fa fa-instagram" aria-hidden="true"></i></a>
            </div>
        <div class="col-sm-6 text-right hidden-xs">
                <ul class="tools">
                    @foreach($category as $value)
                        <li class="">
                            <a class="" href="{{route('home')}}?category={{$value->alias}}"> {{$value->name}}</a>
                        </li>
                    @endforeach
                </ul>
              </div>
        </div>
      </div>
    </nav>   <!--TOP-NAVBAR-END-->


<!--====================== NAVBAR MENU START===================-->
