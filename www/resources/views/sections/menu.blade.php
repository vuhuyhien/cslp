<div class="menu" id="menu">
    <h3>{{__('Categories')}}</h3>
    <ul class="tools">
        @foreach($category as $value)
            <li class="">
                <a class="" href="{{route('home')}}?category={{$value->alias}}"> {{$value->name}}</a>
            </li>
        @endforeach
    </ul>
</div>
<!--====================== NAVBAR MENU START===================-->
