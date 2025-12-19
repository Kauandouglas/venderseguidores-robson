<table class="table table-secondary">
    <thead>
    <tr>
        <th scope="col">PRODUTO</th>
        <th scope="col" colspan="4">PREÇO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($cartProducts as $cartProduct)
        <tr class="item-tr-table">
            <td>
                <div class="d-block ms-0">
                    <p>{{ $cartProduct->service->quantity }} {{ $cartProduct->service->name }}</p>
                </div>
            </td>
            @if($cartProduct->service->type == 4)
                <td><b>Preço: </b> R$ {{ number_format($cartProduct->service->price * substr_count($cartProduct->comment, "\n") + 1, 2, ',', '.') }}</td>
            @else
                <td><b>Preço: </b> R$ {{ number_format($cartProduct->service->price, 2, ',', '.') }}</td>
            @endif
                <td>
                    <button id="cart-product-remove"
                            data-action="{{ route('api.cartProducts.destroy', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                            class="btn btn-danger btn-sm">Remover
                    </button>
                </td>
        </tr>
        <tr class="change-profile">
            <td>
                <input
                    data-action="{{ route('api.cartProducts.addLink', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                    class="input-change-profile" type="text" placeholder="Digite seu Link..."
                    value="{{ $cartProduct->link }}"><br>
                <span class="text-danger show-message d-none"></span>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @if($cartProduct->service->type == 4)
            <tr class="change-profile">
                <td>
                    <p>Comentário</p>
                    <textarea placeholder="Digite seu comentário..." style="max-width: 360px;height: 150px; width: 100%"
                              data-action="{{ route('api.cartProducts.addComment', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                              class="input-change-comment" id="" cols="30"
                              rows="10">{{ $cartProduct->comment }}</textarea><br>
                    <span class="text-danger show-message d-none"></span>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
