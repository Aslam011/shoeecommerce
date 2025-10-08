<div style="width:200px; background:#333; color:#fff; height:100vh; padding:15px;">
    <h3>Menu</h3>
    <ul style="list-style:none; padding:0;">
        <li><a href="{{ route('admin.dashboard') }}" style="color:white;">Dashboard</a></li>
        <li><a href="{{ route('admin.products.index') }}" style="color:white;">Products</a></li>
        <li><a href="{{ route('admin.categories.index') }}" style="color:white;">Categories</a></li>
        <li><a href="{{ route('admin.orders.index') }}" style="color:white;">Orders</a></li>
        <li><a href="{{ route('admin.sliders.index') }}" style="color:white;">Sliders</a></li>
        <li><a href="{{ route('admin.payment-gateways.index') }}" style="color:white;">💳 Payment Gateways</a></li>
        <li>
            <a href="{{ route('admin.logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               style="color:red;">Logout</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
