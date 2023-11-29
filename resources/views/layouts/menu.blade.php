<li class="nav-item {{ Request::is('roles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('roles.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Roles</span>
    </a>
</li>
<li class="nav-item {{ Request::is('types*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('types.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Types</span>
    </a>
</li>
<li class="nav-item {{ Request::is('listings*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('listings.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Listings</span>
    </a>
</li>
<li class="nav-item {{ Request::is('agents*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('agents.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Agents</span>
    </a>
</li>
<li class="nav-item {{ Request::is('categories*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('categories.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Categories</span>
    </a>
</li>
<li class="nav-item {{ Request::is('plans*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('plans.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Plans</span>
    </a>
</li>
