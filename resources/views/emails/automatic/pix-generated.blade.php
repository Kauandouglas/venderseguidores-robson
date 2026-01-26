<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIX Gerado</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #00b894 0%, #00cec9 100%); padding: 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">💰 PIX Gerado!</h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <p style="font-size: 18px; color: #2d3436; margin: 0 0 20px;">
                                Olá <strong>{{ $cliente_nome }}</strong>,
                            </p>
                            <p style="font-size: 16px; color: #636e72; line-height: 1.6; margin: 0 0 30px;">
                                Seu código PIX está pronto para pagamento! Complete a transação para garantir seu pedido.
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
                                        <strong style="color: #2d3436;">💵 Valor:</strong>
                                    </td>
                                    <td style="text-align: right; color: #00b894; font-weight: bold; font-size: 18px;">
                                        {{ $valor_pix }}
                                    </td>
                                </tr>
                            </table>

                            <!-- PIX Code -->
                            <div style="background-color: #2d3436; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                                <p style="color: #00b894; margin: 0 0 10px; font-weight: bold; font-size: 14px;">
                                    📱 CÓDIGO PIX (Copia e Cola):
                                </p>
                                <p style="color: #ffffff; margin: 0; font-family: monospace; font-size: 12px; word-break: break-all; line-height: 1.6;">
                                    {{ $pix_codigo }}
                                </p>
                            </div>

                            <!-- Expiration Warning -->
                            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 0 8px 8px 0; margin-bottom: 30px;">
                                <p style="margin: 0; color: #856404; font-size: 14px;">
                                    ⏰ <strong>Atenção:</strong> Este código expira em <strong>{{ $data_expiracao }}</strong>
                                </p>
                            </div>

                            <p style="font-size: 14px; color: #636e72; line-height: 1.6; margin: 0;">
                                Após o pagamento, seu pedido será processado automaticamente. ⚡
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 20px 30px; text-align: center; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0; color: #636e72; font-size: 14px;">
                                Obrigado pela preferência! 💚
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
