<div id="sidebar-nav" class="sidebar">
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li>
                    <a href="{{ route('docs.pages') }}" class=""><i class="lnr lnr-home"></i> <span>Home</span></a>
                </li>
                @foreach ($menus as $menu)
                <li>
                    <a href="#{{ $menu['page'] }}" data-toggle="collapse" class="collapsed">
                        <i class="lnr lnr-file-empty"></i> <span>{{ $menu['name'] }}</span> <i class="icon-submenu lnr lnr-chevron-left"></i>
                    </a>
                    <div id="{{ $menu['page'] }}" class="collapse">
                        <ul class="nav">
                            @foreach ($menu['children'] as $child)
                                <li>
                                    <a href="?page={{ $menu['page'] }}#{{ $child['page'] }}" class="">
                                        {{ $child['title'] }} &nbsp; 
                                        @switch($child['method'])
                                            @case('POST')
                                            <span class="label label-primary">{{ $child['method'] }}</span> 
                                                @break
                                            @case('GET')
                                            <span class="label label-success">{{ $child['method'] }}</span> 
                                                @break
                                            @case('PATCH')
                                            <span class="label label-warning">{{ $child['method'] }}</span> 
                                                @break
                                            
                                            @case('DELETE')
                                            <span class="label label-danger">{{ $child['method'] }}</span> 
                                                @break
                                            @default
                                            <span class="label label-primary">{{ $child['method'] }}</span>
                                        @endswitch 
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>