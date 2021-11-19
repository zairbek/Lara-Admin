@php
/** @var \App\View\Components\Sidebar\MenuItem $item */
/** @var \App\View\Components\Sidebar\MenuItem $childItem */
@endphp

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach($menu as $item)
            @if($item->child->isNotEmpty())
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link @if($item->active) active @endif">
                        <i class="nav-icon {{ $item->icon }}"></i>
                        <p>
                            {{ $item->title }}
                            @if(! is_null($item->notification))
                                <span class="right badge badge-{{ $item->notification['type'] }}">{{ $item->notification['text'] }}</span>
                            @endif
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($item->child as $childItem)
                            <li class="nav-item">
                                <a href="{{ $childItem->link }}" class="nav-link @if($childItem->active) active @endif">
                                    <i class="nav-icon {{ $childItem->icon }}"></i>
                                    <p>{{ $childItem->title }}</p>
                                    @if(! is_null($item->notification))
                                        <span class="right badge badge-{{ $item->notification['type'] }}">{{ $item->notification['text'] }}</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @elseif($item->link && $item->child->isEmpty())
                <li class="nav-item">
                    <a href="{{ $item->link }}" class="nav-link @if($item->active) active @endif">
                        <i class="nav-icon {{ $item->icon }}"></i>
                        <p>
                            {{ $item->title }}

                            @if(! is_null($item->notification))
                                <span class="right badge badge-{{ $item->notification['type'] }}">{{ $item->notification['text'] }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @else
                <li class="nav-header">{{ $item->title }}</li>
            @endif
        @endforeach
    </ul>
</nav>
