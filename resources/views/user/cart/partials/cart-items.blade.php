@foreach ($cart as $key => $cartItem)
    <x-users.cart-item 
        :image="'storage/' . $cartItem['image']"
        :name="$cartItem['name']"
        :availability="$cartItem['quantity'] > 0 ? 'In Stock' : 'Out of Stock'"
        :quantity="$cartItem['quantity']"
        :price="$cartItem['price'] * $cartItem['quantity']"
        :productId="$key"
    />
@endforeach
