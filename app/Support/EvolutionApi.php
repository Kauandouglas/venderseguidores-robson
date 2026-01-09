<?php

namespace App\Support;

use App\Models\WhatsappInstance;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionApi
{
    private $apiUrl;
    private $apiKey;
    private $instanceName;
    private $instance;

    public function __construct(WhatsappInstance $instance = null)
    {
        // Assumindo que as credenciais globais estão em config/services.php ou .env
        $this->apiUrl = config('services.evolution.url', 'https://robson-evolution-api-evolution-api.kyaafy.easypanel.host');
        $this->apiKey = config('services.evolution.key', '8F3A91D7C2B64E0F9A7C4D128EB5F6A2');
        $this->instance = $instance;

        if ($instance) {
            $this->instanceName = $instance->instance_name;
        }
    }

    private function get(string $endpoint)
    {
        $url = "{$this->apiUrl}/{$endpoint}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
            ])->get($url); // Mudança para o método GET

            if (!$response->successful()) {
                Log::error('Evolution API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'endpoint' => $endpoint,
                ]);
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Evolution API Exception', [
                'message' => $e->getMessage(),
                'endpoint' => $endpoint,
            ]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }


    /**
     * Envia uma requisição POST para a Evolution API
     */
    private function post(string $endpoint, array $data = [])
    {
        $url = "{$this->apiUrl}/{$endpoint}";

        try {
            $response = Http::withHeaders([
                'apikey' => $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            if (!$response->successful()) {
                Log::error('Evolution API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'endpoint' => $endpoint,
                ]);
            }

            return $response->json();

        } catch (\Exception $e) {
            Log::error('Evolution API Exception', [
                'message' => $e->getMessage(),
                'endpoint' => $endpoint,
            ]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Cria uma nova instância na Evolution API
     *
     * @param string $instanceName Nome único da instância
     * @param string $webhookUrl URL para receber webhooks
     * @return array
     */
    public function createInstance(string $instanceName, string $webhookUrl): array
    {
        $endpoint = "instance/create";
        $data = [
            'instanceName' => $instanceName,
            'integration' => 'WHATSAPP-BAILEYS', // obrigatório
            'qrcode' => true,
            'webhookUrl' => $webhookUrl,
            'webhookByEvents' => true,
            'events' => [
                'QRCODE_UPDATED',
                'MESSAGES_UPSERT',
                'CONNECTION_UPDATE',
            ],
        ];

        return $this->post($endpoint, $data);
    }

     /**
     * Configura o webhook para uma instância existente na Evolution API
     *
     * @param string $instanceName Nome único da instância
     * @param string $webhookUrl URL para receber webhooks
     * @param array $events Lista de eventos a serem recebidos
     * @param bool $webhookByEvents Se deve filtrar por eventos
     * @return array
     */
    public function setWebhook(string $instanceName, string $webhookUrl, array $events = [], bool $webhookByEvents = true): array
    {
        if (!$instanceName) {
            return ['error' => true, 'message' => 'Instance name not set.'];
        }

        $endpoint = "instance/webhook";
        $data = [
            'instanceName' => $instanceName,
            'webhookUrl' => $webhookUrl,
            'webhookByEvents' => $webhookByEvents,
            'events' => $events,
        ];

        // Usamos a sua função post() pois o método é POST
        return $this->post($endpoint, $data);
    }

    /**
     * Retorna o QR Code para conexão
     *
     * @return array
     */
    public function getQrCode(): array
    {
        if (!$this->instanceName) {
            return ['error' => true, 'message' => 'Instance not set.'];
        }

        $endpoint = "instance/connect/{$this->instanceName}";
        return $this->get($endpoint);
    }

    /**
     * Envia uma mensagem de texto
     *
     * @param string $number Número de destino (ex: 5511999999999)
     * @param string $message Mensagem a ser enviada
     * @return array
     */
    public function sendText(string $number, string $message): array
    {
        if (!$this->instanceName) {
            return ['error' => true, 'message' => 'Instance not set.'];
        }

        $endpoint = "message/sendText/{$this->instanceName}";
        $data = [
            'number' => $number,
            'text' => $message
        ];

        return $this->post($endpoint, $data);
    }
    
    /**
     * Desconecta a instância
     *
     * @return array
     */
    public function logout(): array
    {
        if (!$this->instanceName) {
            return ['error' => true, 'message' => 'Instance not set.'];
        }

        $endpoint = "instance/logout/{$this->instanceName}";
        return $this->post($endpoint);
    }
}
