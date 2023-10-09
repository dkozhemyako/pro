<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Controller;
use App\Services\TelegramBot\InboundDTO;
use App\Services\TelegramBot\TelegramInboundService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;



class TelegramController extends Controller
{
    public function __construct(
        protected TelegramInboundService $service,
    ){}

    /**
     * @throws GuzzleException
     */
    public function index(Request $request): string
    {

        $data = new InboundDTO($request->all());
        $this->service->handle($data);

        return '';
    }



}
