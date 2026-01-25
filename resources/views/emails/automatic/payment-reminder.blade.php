<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembrete de Pagamento</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #fdcb6e 0%, #f39c12 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">🤔 Esqueceu de algo?</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 18px; color: #2d3436; margin: 0 0 20px;">
                                Opa, <strong>{{ $cliente_nome }}</strong>!
                            </p>
                            <p style="font-size: 16px; color: #636e72; line-height: 1.6; margin: 0 0 30px;">
                                Notamos que você tem um pagamento pendente há <strong>{{ $dias_pendente }} dia(s)</strong>. 
                                Não perca seu pedido!
                            </p>
                            
                            <!-- Order Details -->
                            <table width="100%" cellpadding="15" cellspacing="0" style="background-color: #f8f9fa; border-radius: 8px; margin-bottom: 30px;">
                                <tr>
                                    <td style="border-bottom: 1px solid #e9ecef;">
                                        <strong style="color: #2d3436;">📦 Serviço:</strong>
                                    </td>
                                    <td style="border-bottom: 1px solid #e9ecef; text-align: right; color: #636e72;">
                                        {{ $servico_nome }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong style="color: #2d3436;">💵 Valor Pendente:</strong>
                                    </td>
                                    <td style="text-align: right; color: #f39c12; font-weight: bold; font-size: 18px;">
                                        {{ $valor_pendente }}
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 30px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $link_pagamento }}" style="display: inline-block; background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); color: #ffffff; text-decoration: none; padding: 18px 50px; border-radius: 8px; font-weight: bold; font-size: 18px;">
                                            💳 Pagar Agora
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 14px; color: #636e72; line-height: 1.6; margin: 0; text-align: center;">
                                Complete o pagamento e garanta seu serviço! ⚡
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #636e72; font-size: 14px;">
                                Precisa de ajuda? Responda este email! 💬
                            </p>
                            <p style="margin: 10px 0 0; color: #b2bec3; font-size: 12px;">
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
