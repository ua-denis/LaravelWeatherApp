<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class HomeController extends Controller
{
    private HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $data = $this->homeService->getData();
        return view('home', ['data' => json_encode($data, JSON_PRETTY_PRINT)]);
    }
}
