<div class="p-4">
    <h3 class="text-xl font-bold text-white">Admin Panel</h3>
</div>
<ul class="list-none">
    <li class="py-2">
        <a href="/dashboard" class="block px-4 py-2 text-white hover:bg-gray-700">Dashboard</a>
    </li>
    <li class="py-2">
        <a href="/admin/categories" class="block px-4 py-2 text-white hover:bg-gray-700">Category</a>
    </li>
    <li class="nav-item dropdown block px-4 py-2 hover:bg-gray-700">
        <a href="#" class="nav-link dropdown-toggle" id="productDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Product</a>
        <ul class="dropdown-menu" style="background-color: #0b0b0b" aria-labelledby="productDropdown">
            <li><a class="dropdown-item" href="{{ route('products.index') }}">Product</a></li>
            <li><a class="dropdown-item" href="{{ route('brands.index') }}">Brands</a></li>
            <li><a class="dropdown-item" href="{{ route('attribute-values.index') }}">AttributeValues</a></li>
        </ul>
    </li>
    <li class="py-2">
        <a href="/admin/tags" class="block px-4 py-2 text-white hover:bg-gray-700">Tags</a>
    </li>
</ul>
