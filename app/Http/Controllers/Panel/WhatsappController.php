<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\WhatsappInstance;
use App\Support\EvolutionApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WhatsappController extends Controller
{
    /**
     * Exibe a página de gerenciamento da instância do WhatsApp.
     */
    public function index()
    {
        $user = Auth::user();
        $instance = $user->whatsappInstance;

        // Se a instância existir e estiver desconectada, tenta gerar o QR Code
        if ($instance && $instance->status != 'connected') {
            $evolutionApi = new EvolutionApi($instance);
            $qrCodeData = $evolutionApi->getQrCode();
            
            if (isset($qrCodeData['base64'])) {
                $instance->qr_code = $qrCodeData['base64'];
                $instance->status = 'connecting';
                $instance->save();
                
            }
        }

        return view('panel.whatsapp.index', compact('instance'));
    }

    /**
     * Cria a instância e inicia o processo de conexão.
     */
    public function activate()
    {
        $user = Auth::user();
        $instance = $user->whatsappInstance;

        if ($instance) {
            return redirect()->route('panel.whatsapp.index')->with('error', 'A instância já existe. Desconecte para reativar.');
        }

        $instanceName = 'instance-' . Str::slug($user->domain) . '-' . $user->id;
        $webhookUrl = route('api.webhooks.evolution', ['instanceName' => $instanceName]);

        $evolutionApi = new EvolutionApi();
        $apiResponse = $evolutionApi->createInstance($instanceName, $webhookUrl);

        if (isset($apiResponse['instance'])) {
            $instance = WhatsappInstance::create([
                'user_id' => $user->id,
                'instance_name' => $instanceName,
                'status' => 'disconnected',
            ]);

            // Após criar, tenta obter o QR Code imediatamente
            $evolutionApi = new EvolutionApi($instance);
            $qrCodeData = $evolutionApi->getQrCode();
   
            if (isset($qrCodeData['base64'])) {
                $instance->qr_code = $qrCodeData['base64'];
                $instance->status = 'connecting';
                $instance->save();
                return redirect()->route('panel.whatsapp.index')->with('success', 'Instância criada! Escaneie o QR Code para conectar.');
            }

            return redirect()->route('panel.whatsapp.index')->with('error', 'Instância criada, mas houve um erro ao gerar o QR Code. Tente novamente.');
        }

        return redirect()->route('panel.whatsapp.index')->with('error', 'Erro ao criar instância na API Evolution. Verifique as credenciais.');
    }

    /**
     * Desconecta a instância.
     */
    public function disconnect(Request $request)
    {
        $user = Auth::user();
        $instance = $user->whatsappInstance()->firstOrFail();

        $evolutionApi = new EvolutionApi($instance);
        $response = $evolutionApi->logout();

        if (isset($response['status']) && $response['status'] === 'success') {
            $instance->status = 'disconnected';
            $instance->qr_code = null;
            $instance->save();
            return redirect()->route('panel.whatsapp.index')->with('success', 'Instância desconectada com sucesso.');
        }

        return redirect()->route('panel.whatsapp.index')->with('error', 'Erro ao desconectar a instância.');
    }
}
