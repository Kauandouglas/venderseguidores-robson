<div class="overflow-x-auto">
    <div class="inline-block min-w-full align-middle">
        <div class="overflow-hidden rounded-xl border-2 border-gray-200 shadow-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Table Header -->
                <thead class="bg-gradient-to-r from-gray-700 to-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                            Produto
                        </th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-bold text-white uppercase tracking-wider">
                            Preço
                        </th>
                        <th scope="col" class="px-6 py-4 text-right text-sm font-bold text-white uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartProducts as $index => $cartProduct)
                        <!-- Product Row -->
                        <tr class="hover:bg-gray-50 smooth-transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                                        {{ $cartProduct->service->quantity }}
                                    </span>
                                    <span class="text-gray-900 font-semibold">
                                        {{ $cartProduct->service->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($cartProduct->service->type == 4)
                                    <span class="text-xl font-bold text-green-600">
                                        R$ {{ number_format($cartProduct->service->price * (substr_count($cartProduct->comment, "\n") + 1), 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-xl font-bold text-green-600">
                                        R$ {{ number_format($cartProduct->service->price, 2, ',', '.') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button id="cart-product-remove"
                                        data-action="{{ route('api.cartProducts.destroy', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg smooth-transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remover
                                </button>
                            </td>
                        </tr>

                        <!-- Link Input Row -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-4">
                                <div class="max-w-2xl">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Link do Perfil ou Post
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                            </svg>
                                        </span>
                                        <input type="text"
                                               data-action="{{ route('api.cartProducts.addLink', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                                               class="input-change-profile w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition bg-white"
                                               placeholder="https://instagram.com/seu_perfil"
                                               value="{{ $cartProduct->link }}">
                                    </div>
                                    <span class="text-danger show-message d-none mt-2 text-sm text-red-600 block"></span>
                                </div>
                            </td>
                        </tr>

                        <!-- Comment Input Row (if service type is 4) -->
                        @if($cartProduct->service->type == 4)
                            <tr class="bg-gray-50">
                                <td colspan="3" class="px-6 py-4">
                                    <div class="max-w-2xl">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            Comentários Personalizados
                                        </label>
                                        <div class="relative">
                                            <textarea placeholder="Digite seus comentários, um por linha..."
                                                      data-action="{{ route('api.cartProducts.addComment', ['cartProduct' => $cartProduct, 'domain' => $user->domain, 'ipFixed' => $ipFixed, 'userAgentFixed' => $userAgentFixed]) }}"
                                                      class="input-change-comment w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:outline-none smooth-transition resize-none bg-white"
                                                      rows="5">{{ $cartProduct->comment }}</textarea>
                                            <span class="absolute bottom-3 right-3 text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded font-medium">
                                                {{ substr_count($cartProduct->comment, "\n") + 1 }} comentário(s)
                                            </span>
                                        </div>
                                        <span class="text-danger show-message d-none mt-2 text-sm text-red-600 block"></span>
                                        <p class="mt-2 text-xs text-gray-500 flex items-start gap-1">
                                            <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Separe cada comentário em uma nova linha. O preço será calculado automaticamente.</span>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif

                        <!-- Separator (if not last item) -->
                        @if(!$loop->last)
                            <tr>
                                <td colspan="3" class="px-6 py-0">
                                    <div class="border-t-4 border-gray-300"></div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .smooth-transition {
        transition: all 0.3s ease;
    }
</style>
