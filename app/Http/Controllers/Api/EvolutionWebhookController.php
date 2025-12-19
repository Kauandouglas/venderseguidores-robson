<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WhatsappInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EvolutionWebhookController extends Controller
{
    /**
     * Processa o webhook da Evolution API
     */
    public function handle(Request $request, string $instanceName)
    {
        Log::info("Evolution Webhook Received for {$instanceName}", [
            'headers' => $request->headers->all(),
            'body' => $request->all(),
        ]);

        $instance = WhatsappInstance::where('instance_name', $instanceName)->first();

        if (!$instance) {
            Log::warning("Evolution Webhook: Instance not found for {$instanceName}");
            return response()->json(['status' => 'error', 'message' => 'Instance not found'], 404);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        switch ($event) {
            case 'QRCODE_UPDATED':
                $instance->qr_code = $data['qrcode'];
                $instance->status = 'connecting';
                $instance->save();
                Log::info("Evolution Webhook: QR Code updated for {$instanceName}");
                break;

            case 'CONNECTION_UPDATE':
                $state = $data['state'];
                $status = $data['status'];

                if ($state === 'open' && $status === 'CONNECTED') {
                    $instance->status = 'connected';
                    $instance->qr_code = null;
                    $instance->save();
                    Log::info("Evolution Webhook: Instance connected for {$instanceName}");
                } elseif ($state === 'close') {
                    $instance->status = 'disconnected';
                    $instance->qr_code = null;
                    $instance->save();
                    Log::info("Evolution Webhook: Instance disconnected for {$instanceName}");
                }
                break;

            // Outros eventos podem ser tratados aqui (MESSAGES_UPSERT, etc.)

            default:
                Log::info("Evolution Webhook: Unhandled event {$event} for {$instanceName}");
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }
}
